<style>
  @font-face {
    font-family: 'DIN Next LT Arabic';
    src: url('{{ asset('fonts/ArbFONTS-DINNextLTArabic-UltraLight-4 (1).ttf') }}') format('truetype');
    font-weight: 200;
    font-style: normal;
    font-display: swap;
  }
  @font-face {
    font-family: 'DIN Next LT Arabic';
    src: url('{{ asset('fonts/ArbFONTS-DINNEXTLTARABIC-LIGHT-2-2 (1).ttf') }}') format('truetype');
    font-weight: 300;
    font-style: normal;
    font-display: swap;
  }
  @font-face {
    font-family: 'DIN Next LT Arabic';
    src: url('{{ asset('fonts/ArbFONTS-DINNextLTArabic-Regular-4 (1).ttf') }}') format('truetype');
    font-weight: 400;
    font-style: normal;
    font-display: swap;
  }
  @font-face {
    font-family: 'DIN Next LT Arabic';
    src: url('{{ asset('fonts/ArbFONTS-DINNextLTArabic-Medium-4 (1).ttf') }}') format('truetype');
    font-weight: 500 600;
    font-style: normal;
    font-display: swap;
  }
  @font-face {
    font-family: 'DIN Next LT Arabic';
    src: url('{{ asset('fonts/ArbFONTS-DINNextLTArabic-Bold-4 (1).ttf') }}') format('truetype');
    font-weight: 700 900;
    font-style: normal;
    font-display: swap;
  }
  :root {
    --font-primary: 'DIN Next LT Arabic', ui-sans-serif, system-ui, sans-serif;
    --font-body: var(--font-primary);
    --font-display: var(--font-primary);
  }
</style>
