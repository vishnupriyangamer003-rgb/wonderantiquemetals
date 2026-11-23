<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\ActivityLog;
use App\Support\ImageUploader;
use App\Support\SiteData;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/** Shared list/add/edit/delete/toggle logic. Every save flushes the public cache. */
abstract class ResourceController extends Controller
{
    /** @return class-string<Model> */
    abstract protected function model(): string;

    /** Route/view key, e.g. "banners". */
    abstract protected function key(): string;

    abstract protected function label(): string;

    abstract protected function rules(?Model $item): array;

    /** Column holding an uploaded image, or null. */
    protected function imageField(): ?string
    {
        return null;
    }

    /** Hook to reshape validated input before saving. */
    protected function transform(array $data, Request $request, ?Model $item): array
    {
        return $data;
    }

    public function index(): View
    {
        $model = $this->model();

        return view('admin.'.$this->key().'.index', [
            'items' => $model::orderBy('sort_order')->orderBy('id')->get(),
            'label' => $this->label(),
            'key' => $this->key(),
        ]);
    }

    public function create(): View
    {
        $model = $this->model();

        return view('admin.'.$this->key().'.form', ['item' => new $model(['active' => true, 'sort_order' => $model::max('sort_order') + 1]), 'label' => $this->label(), 'key' => $this->key()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $model = $this->model();
        $data = $this->save($request, null);
        $created = $model::create($data);
        ActivityLog::record('created', $this->label().': '.ActivityLog::itemName($created));
        SiteData::flush();

        return redirect()->route('admin.'.$this->key().'.index')->with('status', $this->label().' added.');
    }

    public function edit(int $id): View
    {
        $model = $this->model();

        return view('admin.'.$this->key().'.form', ['item' => $model::findOrFail($id), 'label' => $this->label(), 'key' => $this->key()]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $model = $this->model();
        $item = $model::findOrFail($id);
        $old = $this->imageField() ? $item->{$this->imageField()} : null;
        $data = $this->save($request, $item);
        $item->update($data);
        ActivityLog::record('updated', $this->label().': '.ActivityLog::itemName($item));
        if ($this->imageField() && $old && $old !== $item->{$this->imageField()}) {
            ImageUploader::delete($old);
        }
        SiteData::flush();

        return redirect()->route('admin.'.$this->key().'.index')->with('status', $this->label().' saved.');
    }

    public function toggle(int $id): RedirectResponse
    {
        $model = $this->model();
        $item = $model::findOrFail($id);
        $item->update(['active' => ! $item->active]);
        ActivityLog::record($item->active ? 'shown' : 'hidden', $this->label().': '.ActivityLog::itemName($item));
        SiteData::flush();

        return back()->with('status', $this->label().($item->active ? ' is now visible.' : ' is now hidden.'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $model = $this->model();
        $item = $model::findOrFail($id);
        if ($this->imageField()) {
            ImageUploader::delete($item->{$this->imageField()});
        }
        ActivityLog::record('deleted', $this->label().': '.ActivityLog::itemName($item));
        $item->delete();
        SiteData::flush();

        return redirect()->route('admin.'.$this->key().'.index')->with('status', $this->label().' deleted.');
    }

    /** Validates, stores any upload, and returns the attributes to persist. */
    private function save(Request $request, ?Model $item): array
    {
        $data = $request->validate($this->rules($item));
        $data['active'] = $request->boolean('active');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        if ($field = $this->imageField()) {
            if ($request->hasFile($field)) {
                $data[$field] = ImageUploader::store($request->file($field), $field);
            } else {
                unset($data[$field]);
            }
        }

        return $this->transform($data, $request, $item);
    }
}
