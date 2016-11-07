<?php

$queHago = isset($_POST['queHago']) ? $_POST['queHago'] : NULL;

switch ($queHago) {
    case "mostrarGrilla":


        require_once 'Estacionamiento.php';
        
        $ArrayDeAutos = Estacionamiento::TraerTodosLosAutos();

        //echo $ArrayDeAutos[0]["id"]."//".$ArrayDeAutos[0]["patente"]."//".$ArrayDeAutos[0]["fingreso"];
        //die();

        $grilla = '<table class="table">
                        <thead style="background:rgb(14, 26, 112);color:#fff;">
                                <tr>
                                    <th rowspan="2">  PATENTE </th>
                                    <th rowspan="2">  FECHA INGRESO  </th>
                                </tr> 
                        </thead>';
        $grilla .= '<tbody>';

        foreach ($ArrayDeAutos as $auto) {
            $grilla .= '<tr>';
            $grilla .= '<td>' . $auto["patente"] .'</td>';
            $grilla .= '<td>' . $auto["fingreso"] . '</td>';

        }
        $grilla .= '</tr>';
        $grilla .= '</table>';
        $grilla .= '<tbody>';
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
                    <input type="text" placeholder="Ingrese la patente" id="txtPatente" />
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
        
         if(isset( $_POST['auto'] ))
        {
            $obj = json_decode(json_encode($_POST["auto"]));    
        }

        $obj = Estacionamiento::TraerUnAuto($obj->patente);

        if (!$obj) {
            $retorno["Exito"] = FALSE;
            $retorno["Mensaje"] = "El vehiculo que quieres sacar no se encuentra estacionado.";
        } else 
        {
            if (!Estacionamiento::EliminarAuto($obj->id)) 
            {
                $retorno["Exito"] = FALSE;
                $retorno["Mensaje"] = "Lamentablemente ocurrio un error y no se pudo estacionarl el vehiculo.";            
            } else {
                $retorno["Mensaje"] = "El vehiculo a sido retirado exitosamente.";
            }            
        }


        echo json_encode($retorno);
        break;

}