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
                    <input type="text" placeholder="Ingrese ID Auto" id="txtIdPatente" />
                    <br>
                    <input type="button" class="MiBotonUTN" onclick="EliminarAuto()" value="Eliminar Auto"  />
                </form>';
        
        echo $form;
        
        break;

    case "agregarAuto":

        require_once 'Estacionamiento.php';

        $retorno["Exito"] = TRUE;
        $retorno["Mensaje"] = "Se ha creado el AUTO";
        $obj = null;
        
        if(isset( $_POST['auto'] ))
        {
            $obj = json_decode(json_encode($_POST["auto"]));    
        }

        var_dump($obj);

        if (!Estacionamiento::InsertarAuto($obj->patente))
        {
            $retorno["Exito"] = FALSE;
            $retorno["Mensaje"] = "Lamentablemente ocurrio un error y no se pudo agregar la patente.";
        } else {
            $retorno["Mensaje"] = "La patente fue agregada CORRECTAMENTE!!!";
        }

        echo json_encode($retorno);

        break;

    case "eliminarAuto":
        
        require_once 'Estacionamiento.php';
        
        $retorno["Exito"] = TRUE;
        $retorno["Mensaje"] = "";
        
        $idPatente = isset($_POST['idPatente']) ? $_POST['idPatente'] : NULL;
        
//        echo  var_dump($idPatente);
//        die();

        if (!Estacionamiento::Eliminar($idPatente)) {
            $retorno["Exito"] = FALSE;
            $retorno["Mensaje"] = "Lamentablemente ocurrio un error y no se pudo ELIMINAR la patente.";
        } else {
            $retorno["Mensaje"] = "El auto fue eliminada CORRECTAMENTE!!!";
        }

        echo json_encode($retorno);
        break;

}