<?php
date_default_timezone_set('America/Chihuahua');
$datetime = date_create()->format('Y-m-d H:i:s');
//$conexion = mysqli_connect("localhost:1234", "root", "");
$conexion = new mysqli("localhost:1234", "root", "", "tspvcomm_proveedores_test");

//$conexion = mysql_connect("localhost", "tspvcomm", "CR@P1030!EFM0ti");
$date = date_create(); 

$dia=date("l");

require_once("lib/nusoap.php");

if($_POST['user'] && $_POST['pass']) {
	
     $sql="SELECT nombre FROM users WHERE id='".$_POST['user']."' AND password='".md5($_POST['pass'])."'";
     $rfc="SELECT id FROM users WHERE id='".$_POST['user']."' AND password='".md5($_POST['pass'])."'";
     $correo="SELECT correo FROM users WHERE id='".$_POST['user']."' AND password='".md5($_POST['pass'])."'";
     $fletero="SELECT id,cve_proveedor FROM users WHERE id='".$_POST['user']."' AND password='".md5($_POST['pass'])."' AND fletero=1";
     
     $cve_prov="SELECT id,cve_proveedor FROM users WHERE id='".$_POST['user']."' AND password='".md5($_POST['pass'])."'";
     $oc_update="UPDATE users a JOIN tmpusers b ON a.id = b.id SET a.COBLIGAOC = b.COBLIGAOC WHERE trim(a.id)='".trim($_POST['user'])."'";
     $oc_obligatorio="SELECT COBLIGAOC FROM users WHERE trim(id)='".trim($_POST['user'])."'";
     $vcCuliacan="SELECT U.id FROM `users` U JOIN `inv_ocpendientes` O ON O.CCVE_PROVEEDOR=U.cve_proveedor WHERE O.cSucursal='001' AND trim(U.id)='".trim($_POST['user'])."' LIMIT 1";
     $vcCdguzman="SELECT U.id FROM `users` U JOIN `inv_ocpendientes` O ON O.CCVE_PROVEEDOR=U.cve_proveedor WHERE O.cSucursal='003' AND trim(U.id)='".trim($_POST['user'])."' LIMIT 1";
     $res_oc=$conexion->query($oc_update) or die ("Error actualizando oc");     
     $resultado=$conexion->query($sql) or die ("Error");
     $res=$conexion->query($rfc) or die ("Error con el rfc");
     
     $res_mail=$conexion->query($correo) or die ("Error con el correo");
     $flet=$conexion->query($fletero) or die ("Error con el fletero");
     $oco=$conexion->query($oc_obligatorio) or die ("Error con el usuario con orden de compra obligatoria");
     $prov=$conexion->query($cve_prov) or die ("Error con el proveedor");
     print_r($prov);
     var_dump($prov);
     $vResCuliacan=$conexion->query($vcCuliacan) or die ("Error con el usuario Culiacan");
     $vResCdguzman=$conexion->query($vcCdguzman) or die ("Error con el usuario Cd. Guzman");
     
     //$trailero=$conexion->query($flet,0,0);
     $traileroResult = $flet;
     $trailero = $traileroResult->fetch_assoc();
     print_r( $trailero);
     //$oc_required=$conexion->query($oco,0,0);
     $ocRequiredResult = $oco;
     $oc_required = $ocRequiredResult->fetch_assoc();

     //$trans=$conexion->query($flet,0,1);
     $transResult = $flet;
     $trans = $transResult->fetch_assoc();

     //$cve=$conexion->query($prov,0,1);
     $cveResult = $prov;
     $cve = $cveResult->fetch_assoc();


     $numRegistros=$resultado->num_rows;
     $vnRegculiacan=$vResCuliacan->num_rows;
     $vnRegcdguzman=$vResCdguzman->num_rows;
     if($numRegistros==0) {
        header("location: log.php?error=1");
    } else {
        session_start();
        $_SESSION["autentica"] = "OK"; 
        //$_SESSION["user"] = mysql_result($resultado,0,0); 
        $_SESSION["user"] = $resultado->fetch_assoc()['nombre'];
        //$_SESSION["rfc"] = mysql_result($res,0,0); 
        $_SESSION["rfc"] = $res->fetch_assoc()['id'];

        
        //$_SESSION["correo"] = mysql_result($res_mail,0,0); 
        $_SESSION["correo"] = $res_mail->fetch_assoc()['correo'];
        $_SESSION["fecha"] = date("Y/m/d H:i:s");
        $_SESSION["trans"] = $trans;//variable de sesion de clave de proveedor de transportista
        $_SESSION["cve_pro"] = $cve;
        $_SESSION["oc_r"]= $oc_required;
        $_record_xml = "INSERT INTO logs (id,fecha) VALUES ('".trim($_SESSION["rfc"])."','".trim($_SESSION["fecha"])."')";
        //mysql_query($_record_xml);
        mysqli_query($conexion, $_record_xml);
        if(trim($_POST['user'])=='kareli'){
            $_SESSION["security"] = "OK";
            header("location: consulta_int.php");
        }
        elseif(trim($_POST['user'])=='arturopp'){
            $_SESSION["security"] = "OK";
            header("location: consulta_intfact.php");
        }
        elseif(trim($_POST['user'])==trim($trailero)) {
            header("location: inicio.php");
        }
        else{
            if($oc_required=='S'){
                if($dia=="Saturday" or $dia=="Friday"){
                //if($dia=="Monday"){
                    header("location: http://www.aparedes.com.mx/proveedores/standby/"); 
                    $_SESSION["autentica"] = "NO";                   
                }
                else{
                    if ($vnRegculiacan>0 and $vnRegcdguzman>0) {
                        $_SESSION["sucursal"]="";
                        $_SESSION["bScursal"]=1;
                        header("location: seleccionasucursal.php");      
                    }else{
                        if($vnRegculiacan>0){
                            $_SESSION["sucursal"]="001";
                        }elseif ($vnRegcdguzman>0) {
                            $_SESSION["sucursal"]="003";
                        }
                        else{
                            $_SESSION["sucursal"]="001";
                        }

                        $temp="SELECT CCVE_TEMPORADA FROM CTL_TEMPORADAS WHERE NACTIVO=1 AND CSUCURSAL='".$_SESSION["sucursal"]."'";
                        $restemp=$conexion->query($temp) or die ("Error con la temporada");
                        //$_SESSION["temporada"] = mysql_result($restemp,0,0); 
                        $_SESSION["temporada"] = $restemp->fetch_assoc()['CCVE_TEMPORADA'];


                        header("location: inicio-normal.php");      
                    }
                }
            }else{
                if ($vnRegculiacan>0 and $vnRegcdguzman>0) {
                    $_SESSION["sucursal"]="";
                    $_SESSION["bScursal"]=1;
                    header("location: seleccionasucursal.php");      
                }else{
                    if($vnRegculiacan>0){
                        $_SESSION["sucursal"]="001";
                    }elseif ($vnRegcdguzman>0) {
                        $_SESSION["sucursal"]="003";
                    }
                    else{
                        $_SESSION["sucursal"]="001";
                    }

                    $temp="SELECT CCVE_TEMPORADA FROM CTL_TEMPORADAS WHERE NACTIVO=1 AND CSUCURSAL='".$_SESSION["sucursal"]."'";
                    $restemp=$conexion->query($temp) or die ("Error con la temporada");
                    //$_SESSION["temporada"] = mysql_result($restemp,0,0); 
                    $_SESSION["temporada"] = $restemp->fetch_assoc()['CCVE_TEMPORADA'];


                    header("location: inicio-normal.php");
                }        
            }    
        }
    }
}
else{
    header("location: log.php?error=2");
}
?>