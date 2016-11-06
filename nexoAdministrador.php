<?php

$queHago = isset($_POST['queHago']) ? $_POST['queHago'] : NULL;

switch ($queHago) {
    case "mostrarGrilla":


        require_once 'clases/MostrarJson.php';
        
        $ArrayDeMascotas = MostrarJson::TraerTodosLasMascotas();


        $grilla = '<table class="table">
                        <thead style="background:rgb(14, 26, 112);color:#fff;">
                                <tr>
                                    <th rowspan="2">  ID </th>
                                    <th rowspan="2">  PATENTE </th>
                                    <th rowspan="2">  FECHA  </th>
                                    <th style="text-align:center">  DUE&Ntilde;O </th>
                                </tr> 
                                <tr>
                                    <th>
                                        <table>
                                            <thead style="background:rgb(14, 26, 112);color:#fff;">
                                                <tr>
                                                    <th> NOMBRE </th>
                                                    <th> CIUDAD </th>
                                                    <th> TELEFONO </th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </th>
                                </tr>
                        </thead>';
        $grilla .= '<tbody>';

        foreach ($ArrayDeMascotas as $mascota) {
            $grilla .= '<tr>';
            $grilla .= '<td>' . $mascota["id"] .'</td>';
            $grilla .= '<td>' . $mascota["nombre"] . '</td>';
            $grilla .= '<td>' . $mascota["tipo"] . '</td>';
            $grilla .= '<td><img src="' . $mascota["foto"] . '" /></td>';
            $grilla .= '<td>' . $mascota["dueño"]["nombre"] . ' ';
            $grilla .=  $mascota["dueño"]["datos"]["ciudad"] . ' ';
            $grilla .=  $mascota["dueño"]["datos"]["telefono"] . '</td>';
            //Armar filas con los datos de las mascotas
        }

        $grilla .= '</table>';

        echo $grilla;

        break;

    case "cargarForm":

        $form = '<form>   
                    
                    <label >INGRESAR AUTO:</label>
                    <input type="text" placeholder="Ingrese PATENTE" id="txtPatente" />
                    <input type="button" class="MiBotonUTN" onclick="AgregarAuto()" value="Estacionar Auto"  />
                </form>';
        
        echo $form;
        
        break;

    case "cargarFormEliminar":

        $form = '<form>   
                    <input type="text" placeholder="Ingrese ID Mascota" id="txtIdMascota" />
                    <br>
                    <input type="button" class="MiBotonUTN" onclick="EliminarMascota()" value="Eliminar Mascota"  />
                </form>';
        
        echo $form;
        
        break;

    case "agregarAuto":

        require_once 'Estacionamiento.php';
        $retorno["Exito"] = TRUE;
        $retorno["Mensaje"] = "Se ha creado el AUTO";
        $obj = null;
        echo json_encode($retorno);
        die();

        /*if(isset( $_POST['auto'] ))
        {
            $obj = json_decode(json_encode($_POST["auto"]),true);    
        }*/
        $obj =  isset( $_POST['auto'] ) ? json_decode(json_encode($_POST['auto'])) : NULL;

        $auto = new Estacionamiento($obj->patente, $obj->fecha);
        
        //echo var_dump($cel);
        //die();        

        if (!$cel->Agregar()) {
            $retorno["Exito"] = FALSE;
            $retorno["Mensaje"] = "Lamentablemente ocurrio un error y no se pudo AGREGAR el celular.";
        } else {
            $retorno["Mensaje"] = "El celular fue agregado CORRECTAMENTE!!!";
        }

        echo json_encode($retorno);

        break;

    case "eliminarMascota":
        
        require_once 'clases/Mascota.php';
        
        $retorno["Exito"] = TRUE;
        $retorno["Mensaje"] = "";
        
        $idMascota = isset($_POST['idMascota']) ? $_POST['idMascota'] : NULL;
        
//        echo  var_dump($idMascota);
//        die();

        if (!Mascota::Eliminar($idMascota)) {
            $retorno["Exito"] = FALSE;
            $retorno["Mensaje"] = "Lamentablemente ocurrio un error y no se pudo ELIMINAR la mascota.";
        } else {
            $retorno["Mensaje"] = "La mascota fue eliminada CORRECTAMENTE!!!";
        }

        echo json_encode($retorno);
        break;

        
    case "cargarFormSubir":

        $form = '<form>   
                    <input type="file" placeholder="Ingrese ID Mascota" id="subir" />
                    <br>
                    <input type="button" class="MiBotonUTN" onclick="SubirArchivo()" value="Subir Archivo"  />
                </form>';
        
        echo $form;
        
        break;

    default:
        echo ":(";
}