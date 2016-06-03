<?php
namespace sururulab\BrasilHelper;

use sururulab\BrasilHelper\lib\pierophp\InscricaoEstadual;

/**
* Brasil Helper é um projeto open source que empacota via pacote composer um poderoso helper de utilidades para quem desenvolve software para regionalização do Brasil.
* 
*/
class BrasilHelper
{

    public static function checkIE($ie = false, $uf = false)
    {
        $InscricaoEstadual = new InscricaoEstadual();
        return $InscricaoEstadual->inscricao_estadual($ie, $uf);
    }
    /**
     * Estados Brasileiros
     * 
     * @author Lucas Barros <lucas@cloudic.com.br>
     * @return array Lista de estados sigla => nome
     *
     */
    public static function estados(){
        return array("AC"=>"Acre", "AL"=>"Alagoas", "AM"=>"Amazonas", "AP"=>"Amapá","BA"=>"Bahia","CE"=>"Ceará","DF"=>"Distrito Federal","ES"=>"Espírito Santo","GO"=>"Goiás","MA"=>"Maranhão","MT"=>"Mato Grosso","MS"=>"Mato Grosso do Sul","MG"=>"Minas Gerais","PA"=>"Pará","PB"=>"Paraíba","PR"=>"Paraná","PE"=>"Pernambuco","PI"=>"Piauí","RJ"=>"Rio de Janeiro","RN"=>"Rio Grande do Norte","RO"=>"Rondônia","RS"=>"Rio Grande do Sul","RR"=>"Roraima","SC"=>"Santa Catarina","SE"=>"Sergipe","SP"=>"São Paulo","TO"=>"Tocantins");
    }

    /**
     * Valida CNPJ
     *
     * Esta função testa se um Cnpj é valido ou não. 
     *
     * @author  Raoni Botelho Sporteman <raonibs@gmail.com>
     * @version 1.0 Debugada em 27/09/2011 no PHP 5.3.8
     * @param   string      $cnpj           Guarda o Cnpj como ele foi digitado pelo cliente
     * @param   array       $num            Guarda apenas os números do Cnpj
     * @param   boolean     $isCnpjValid    Guarda o retorno da função
     * @param   int         $multiplica     Auxilia no Calculo dos Dígitos verificadores
     * @param   int         $soma           Auxilia no Calculo dos Dígitos verificadores
     * @param   int         $resto          Auxilia no Calculo dos Dígitos verificadores
     * @param   int         $dg             Dígito verificador
     * @return  boolean                     "true" se o Cnpj é válido ou "false" caso o contrário
     *
     */
     
     public static function checkCNPJ($cnpj)
        {
            //Etapa 1: Cria um array com apenas os digitos numéricos, isso permite receber o cnpj em diferentes formatos como "00.000.000/0000-00", "00000000000000", "00 000 000 0000 00" etc...
            $j=0;
            for($i=0; $i<(strlen($cnpj)); $i++)
                {
                    if(is_numeric($cnpj[$i]))
                        {
                            $num[$j]=$cnpj[$i];
                            $j++;
                        }
                }
            //Etapa 2: Conta os dígitos, um Cnpj válido possui 14 dígitos numéricos.
            if(count($num)!=14)
                {
                    $isCnpjValid=false;
                }
            //Etapa 3: O número 00000000000 embora não seja um cnpj real resultaria um cnpj válido após o calculo dos dígitos verificares e por isso precisa ser filtradas nesta etapa.
            if ($num[0]==0 && $num[1]==0 && $num[2]==0 && $num[3]==0 && $num[4]==0 && $num[5]==0 && $num[6]==0 && $num[7]==0 && $num[8]==0 && $num[9]==0 && $num[10]==0 && $num[11]==0)
                {
                    $isCnpjValid=false;
                }
            //Etapa 4: Calcula e compara o primeiro dígito verificador.
            else
                {
                    $j=5;
                    for($i=0; $i<4; $i++)
                        {
                            $multiplica[$i]=$num[$i]*$j;
                            $j--;
                        }
                    $soma = array_sum($multiplica);
                    $j=9;
                    for($i=4; $i<12; $i++)
                        {
                            $multiplica[$i]=$num[$i]*$j;
                            $j--;
                        }
                    $soma = array_sum($multiplica); 
                    $resto = $soma%11;          
                    if($resto<2)
                        {
                            $dg=0;
                        }
                    else
                        {
                            $dg=11-$resto;
                        }
                    if($dg!=$num[12])
                        {
                            $isCnpjValid=false;
                        } 
                }
            //Etapa 5: Calcula e compara o segundo dígito verificador.
            if(!isset($isCnpjValid))
                {
                    $j=6;
                    for($i=0; $i<5; $i++)
                        {
                            $multiplica[$i]=$num[$i]*$j;
                            $j--;
                        }
                    $soma = array_sum($multiplica);
                    $j=9;
                    for($i=5; $i<13; $i++)
                        {
                            $multiplica[$i]=$num[$i]*$j;
                            $j--;
                        }
                    $soma = array_sum($multiplica); 
                    $resto = $soma%11;          
                    if($resto<2)
                        {
                            $dg=0;
                        }
                    else
                        {
                            $dg=11-$resto;
                        }
                    if($dg!=$num[13])
                        {
                            $isCnpjValid=false;
                        }
                    else
                        {
                            $isCnpjValid=true;
                        }
                }
            //Trecho usado para depurar erros.
            /*
            if($isCnpjValid==true)
                {
                    echo "<p><font color="GREEN">Cnpj é Válido</font></p>";
                }
            if($isCnpjValid==false)
                {
                    echo "<p><font color="RED">Cnpj Inválido</font></p>";
                }
            */
            //Etapa 6: Retorna o Resultado em um valor booleano.
            return $isCnpjValid;            
        }

    /**
     * Valida CPF (original valida_cpf() by Luiz Otávio)
     * 
     * @author Luiz Otávio Miranda <contato@todoespacoonline.com/w> 
     * @param string $cpf O CPF com ou sem pontos e traço
     * @return bool True para CPF correto - False para CPF incorreto
     *
     */
    public static function checkCPF( $cpf = false ) {
        // Exemplo de CPF: 025.462.884-23
        
        /**
         * Multiplica dígitos vezes posições 
         *
         * @param string $digitos Os digitos desejados
         * @param int $posicoes A posição que vai iniciar a regressão
         * @param int $soma_digitos A soma das multiplicações entre posições e dígitos
         * @return int Os dígitos enviados concatenados com o último dígito
         *
         */
        if ( ! function_exists('calc_digitos_posicoes') ) {
            function calc_digitos_posicoes( $digitos, $posicoes = 10, $soma_digitos = 0 ) {
                // Faz a soma dos dígitos com a posição
                // Ex. para 10 posições: 
                //   0    2    5    4    6    2    8    8   4
                // x10   x9   x8   x7   x6   x5   x4   x3  x2
                //   0 + 18 + 40 + 28 + 36 + 10 + 32 + 24 + 8 = 196
                for ( $i = 0; $i < strlen( $digitos ); $i++  ) {
                    $soma_digitos = $soma_digitos + ( $digitos[$i] * $posicoes );
                    $posicoes--;
                }
         
                // Captura o resto da divisão entre $soma_digitos dividido por 11
                // Ex.: 196 % 11 = 9
                $soma_digitos = $soma_digitos % 11;
         
                // Verifica se $soma_digitos é menor que 2
                if ( $soma_digitos < 2 ) {
                    // $soma_digitos agora será zero
                    $soma_digitos = 0;
                } else {
                    // Se for maior que 2, o resultado é 11 menos $soma_digitos
                    // Ex.: 11 - 9 = 2
                    // Nosso dígito procurado é 2
                    $soma_digitos = 11 - $soma_digitos;
                }
         
                // Concatena mais um dígito aos primeiro nove dígitos
                // Ex.: 025462884 + 2 = 0254628842
                $cpf = $digitos . $soma_digitos;
                
                // Retorna
                return $cpf;
            }
        }
        
        // Verifica se o CPF foi enviado
        if ( ! $cpf ) {
            return false;
        }
     
        // Remove tudo que não é número do CPF
        // Ex.: 025.462.884-23 = 02546288423
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
     
        // Verifica se o CPF tem 11 caracteres
        // Ex.: 02546288423 = 11 números
        if ( strlen( $cpf ) != 11 ) {
            return false;
        }   
     
        // Captura os 9 primeiros dígitos do CPF
        // Ex.: 02546288423 = 025462884
        $digitos = substr($cpf, 0, 9);
        
        // Faz o cálculo dos 9 primeiros dígitos do CPF para obter o primeiro dígito
        $novo_cpf = calc_digitos_posicoes( $digitos );
        
        // Faz o cálculo dos 10 dígitos do CPF para obter o último dígito
        $novo_cpf = calc_digitos_posicoes( $novo_cpf, 11 );
        
        // Verifica se o novo CPF gerado é idêntico ao CPF enviado
        if ( $novo_cpf === $cpf ) {
            // CPF válido
            return true;
        } else {
            // CPF inválido
            return false;
        }
    }
}