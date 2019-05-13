/**
 * La funcion reSizeImg cambia el sorce de una imagen por otro cuando se cambia o un tamaño
 * 
 * @author Fran Blanco <https://panchoblanco.com/>
 * 
 * @version 0.1
 * 
 * @param String selecThor el selector para el qS
 * @param String src1 es el camino relativo al archivo si es mas 
 * chico del tamaño 
 * @param String src2 es el camino relativo al archivo si es mas 
 * grande del tamaño
 * @param Int size el tamaño para cambiar el sorce. Por defecto 
 * 768px
 * @param Bool dabug variable para activar los logs de debug
 * 
 */
function reSizeImg(selecThor, src1, src2, size = 768, debug = false)
{
  const DEBUG = debug;
  let node = document.querySelector(selecThor);
  DEBUG ? console.log('Selector',node) : '';
  if (window.innerWidth <= size) {
    node.src = src1;
    DEBUG ? console.log('Fuente Chica',src1) : '';
    DEBUG ? console.log(node.src) : '';
  } else {
    node.src = src2;
    DEBUG ? console.log('Fuente Grande',src2) : '';
    DEBUG ? console.log(node.src) : '';
  }
}