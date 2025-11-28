export function initTextInputs() {
  const inputs = document.querySelectorAll('.input-text');

  inputs.forEach(wrapper => {
    const input = wrapper.querySelector('.input-text__input');

    if (!input) {
      console.warn('TextInput: input field not found', wrapper);
      return;
    }

    // Клик по обёртке для фокуса
    wrapper.addEventListener('click', (e) => {
      if (e.target !== input) {
        input.focus();
      }
    });
  });

  console.log(`✅ Initialized ${inputs.length} text input(s)`);
}
