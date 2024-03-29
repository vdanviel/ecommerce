<?php
#Template serve para resolver assuntos do template (como rotas da URL)

namespace PERSONAL\TEMPLATE;

class Visual{

    public static function levelTheRoute(){#retorna '../' para cada rota acima de 1
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
            
            //localhost version
        }else{# se não estiver no localhost o processo é feito sem excluir nada na string $uriname, igual é feito anteriormente

            $filelevel = substr_count($uriname, '/');

            for ($i=0;$i < $filelevel; $i++) { 
                
                if ($i == 0) {
                    echo "";
                }else{
                    echo "../";
                }

            }

            //default host version
        }
    }

    public static function formatprice($price){

        if(!$price > 0) $price = 0;
        
        echo str_replace(".",",",$price);

    }

    public static function all_array_are_equal($array = array(), $column, $value){

        $data = array_column($array,$column);

        if (count(array_unique($data)) == 1 && array_unique($data)[0] == $value) {
            return true;//todos os pedidos do user estão cancelados
        }else{
            return false;//nem todos os pedidos esão cancelados
        }

    }
}
