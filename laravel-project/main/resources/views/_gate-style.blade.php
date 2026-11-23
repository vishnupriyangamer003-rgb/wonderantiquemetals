<style>
    .gate { min-height: 100vh; display: grid; place-items: center; padding: 40px 20px; background: var(--paper, #f3f0e8); }
    .gate__card {
        width: 100%; max-width: 460px; background: #fff;
        border: 1px solid var(--line, rgba(41, 38, 33, .18));
        border-radius: 4px; padding: 46px 38px 38px;
        box-shadow: 0 24px 60px rgba(41, 38, 33, .10);
    }
    .gate__brand { display: flex; align-items: center; gap: 12px; margin-bottom: 30px; }
    .gate__brand img { height: 44px; width: auto; }
    .gate__brand span { font: 400 20px/1.2 var(--serif, "Bodoni 72", "Didot", serif); }
    .gate__brand span em { font-style: italic; color: var(--rust, #a64c38); }
    .gate__eyebrow { margin: 0 0 8px; font-size: 11px; letter-spacing: .22em; text-transform: uppercase; color: var(--rust, #a64c38); }
    .gate h1 { margin: 0 0 10px; font: 400 30px/1.2 var(--serif, "Bodoni 72", "Didot", serif); }
    .gate__lead { margin: 0 0 26px; color: var(--muted, #777166); font-size: 14.5px; }
    .gate__field { display: grid; gap: 7px; margin-bottom: 20px; }
    .gate__field label { font-size: 12px; letter-spacing: .14em; text-transform: uppercase; font-weight: 700; }
    .gate__field input {
        width: 100%; padding: 14px 15px; font: inherit; color: inherit;
        background: var(--paper, #f3f0e8);
        border: 1px solid var(--line, rgba(41, 38, 33, .18)); border-radius: 3px;
    }
    .gate__field input:focus { outline: 2px solid var(--rust, #a64c38); outline-offset: 1px; border-color: transparent; }
    .gate__fielderr { font-size: 13px; color: #b3261e; }
    .gate__code { text-align: center; font-size: 34px; letter-spacing: .42em; font-weight: 700; }
    .gate__btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 10px;
        width: 100%; min-height: 50px; padding: 0 18px; border: 0; cursor: pointer;
        font: 600 15px/1 inherit; letter-spacing: .14em; text-transform: uppercase;
        background: var(--ink, #292621); color: var(--paper, #f3f0e8);
        transition: background-color 180ms ease, transform 180ms ease;
    }
    .gate__btn:hover, .gate__btn:focus-visible { background: var(--rust, #a64c38); transform: translateY(-2px); }
    .gate__errors { margin: 0 0 18px; padding: 12px 15px; background: #fde4e2; color: #b3261e; border-radius: 3px; font-size: 14px; }
    .gate__status { margin: 0 0 18px; padding: 12px 15px; background: #dff3e8; color: #1f7a4d; border-radius: 3px; font-size: 14px; }
    .gate__meta { margin: 18px 0 0; font-size: 13px; color: var(--muted, #777166); text-align: center; }
    .gate__meta a { color: var(--rust, #a64c38); }
    @media (max-width: 480px) { .gate__card { padding: 34px 22px 28px; } }
</style>
