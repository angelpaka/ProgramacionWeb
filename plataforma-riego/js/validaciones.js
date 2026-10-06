// Validaciones del formulario de registro de riego (lado cliente)
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('form-riego');
  if (!form) return;

  const hoy = new Date().toISOString().split('T')[0];
  form.fecha.max = hoy;               // no se permiten fechas futuras
  if (!form.fecha.value) form.fecha.value = hoy;

  // Muestra o limpia el mensaje de error de un campo
  function marcar(campo, mensaje) {
    document.getElementById('err-' + campo.name).textContent = mensaje;
    campo.classList.toggle('invalido', mensaje !== '');
    return mensaje === '';
  }

  // Reglas por campo
  const reglas = {
    parcela_id: c => marcar(c, c.value ? '' : 'Selecciona una parcela.'),
    fecha: c => marcar(c, !c.value ? 'Indica la fecha del riego.' : c.value > hoy ? 'La fecha no puede ser futura.' : ''),
    duracion_min: c => marcar(c, Number(c.value) > 0 && Number.isInteger(Number(c.value)) ? '' : 'Ingresa minutos enteros mayores a 0.'),
    cantidad_litros: c => marcar(c, Number(c.value) > 0 ? '' : 'Ingresa litros mayores a 0.'),
  };

  Object.keys(reglas).forEach(n => form[n].addEventListener('blur', () => reglas[n](form[n])));

  form.addEventListener('submit', e => {
    const validos = Object.keys(reglas).map(n => reglas[n](form[n]));
    if (validos.includes(false)) {
      e.preventDefault();             // bloquea el envío si hay errores
      form.querySelector('.invalido').focus();
    }
  });
});
