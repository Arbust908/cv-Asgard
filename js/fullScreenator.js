/**
 * El script este viene a solucionar el problema de los navegadores 
 * mobile que no en 100vh no ocupan toda la pantalla sino mas por 
 * la barra superior
 * 
 * @author Fran Blanco <https://panchoblanco.com/>
 * 
 * @version 0.1
 * 
 * @param String selecThor el selector para el qS al que le 
 * cambiamos el alto
 * @param Bool dabug variable para activar los logs de debug
 * 
 */
function fullScreenator(selecThor, debug = false)
{
  const DEBUG = debug;
  let box = document.querySelector(selecThor);
  DEBUG ? console.log(box) : '';
  DEBUG ? console.log(innerHeight) : '';
  box.style.hight = window.innerHeight;
  DEBUG ? console.log(box.style.hight) : '';
}
