<?php
#Template serve para resolver assuntos do template (como rotas da URL)

namespace PERSONAL\TEMPLATE;

class Visual
{

    public static function levelTheRoute()#retorna '../' para cada rota acima de 1
    {
        #uri da paginal atual
        $uriname = $_SERVER['REQUEST_URI']; #$_SERVER['REQUEST_URI'] - retorna o caminho depois do host.

        #se estiver no localhost, excluimos o "/ecommerce" para conseguirmos ter o efito corretamente
        if (strpos($uriname, "/ecommerce") !== false) {
            $newuriname = str_replace("/ecommerce", "", $uriname); #excluindo "/ecommerce"
            
            $filelevel = substr_count($newuriname, '/'); #contando o tanto de barras para saber o nivel da paginal atual

            for ($i=0;$i < $filelevel; $i++) { #para cada nivel um echo "../"
                
                if ($i == 0) {#seu houver apenas um "/" então está na raiz, não mexemos em nada
                    echo "";
                }else{
                    echo "../";
                }

            }
            
            return "Localhost version";
        }else{# se não estiver no localhost o processo é feito sem excluir nada na string $uriname, igual é feito anteriormente

            $filelevel = substr_count($uriname, '/');

            for ($i=0;$i < $filelevel; $i++) { 
                
                if ($i == 0) {
                    echo "";
                }else{
                    echo "../";
                }

            }

            return "Default host version";
        }
    }
}
