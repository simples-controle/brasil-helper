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
            $num = 0;
            
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
                    return false;
                }
            //Etapa 3: O número 00000000000 embora não seja um cnpj real resultaria um cnpj válido após o calculo dos dígitos verificares e por isso precisa ser filtradas nesta etapa.
            if ($num[0]==0 && $num[1]==0 && $num[2]==0 && $num[3]==0 && $num[4]==0 && $num[5]==0 && $num[6]==0 && $num[7]==0 && $num[8]==0 && $num[9]==0 && $num[10]==0 && $num[11]==0)
                {
                    return false;
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
                            return false;
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
                            return false;
                        }
                    else
                        {
                            return true;
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
    
    public static function bancosBrasileiros()
    {
        return array(
        	array('code' => '001', 'name' => 'Banco do Brasil'),
        	array('code' => '003', 'name' => 'Banco da Amazônia'),
        	array('code' => '004', 'name' => 'Banco do Nordeste'),
        	array('code' => '021', 'name' => 'Banestes'),
        	array('code' => '025', 'name' => 'Banco Alfa'),
        	array('code' => '027', 'name' => 'Besc'),
        	array('code' => '029', 'name' => 'Banerj'),
        	array('code' => '031', 'name' => 'Banco Beg'),
        	array('code' => '033', 'name' => 'Banco Santander Banespa'),
        	array('code' => '036', 'name' => 'Banco Bem'),
        	array('code' => '037', 'name' => 'Banpará'),
        	array('code' => '038', 'name' => 'Banestado'),
        	array('code' => '039', 'name' => 'BEP'),
        	array('code' => '040', 'name' => 'Banco Cargill'),
        	array('code' => '041', 'name' => 'Banrisul'),
        	array('code' => '044', 'name' => 'BVA'),
        	array('code' => '045', 'name' => 'Banco Opportunity'),
        	array('code' => '047', 'name' => 'Banese'),
        	array('code' => '062', 'name' => 'Hipercard'),
        	array('code' => '063', 'name' => 'Ibibank'),
        	array('code' => '065', 'name' => 'Lemon Bank'),
        	array('code' => '066', 'name' => 'Banco Morgan Stanley Dean Witter'),
        	array('code' => '069', 'name' => 'BPN Brasil'),
        	array('code' => '070', 'name' => 'Banco de Brasília – BRB'),
        	array('code' => '072', 'name' => 'Banco Rural'),
        	array('code' => '073', 'name' => 'Banco Popular'),
        	array('code' => '074', 'name' => 'Banco J. Safra'),
        	array('code' => '075', 'name' => 'Banco CR2'),
        	array('code' => '076', 'name' => 'Banco KDB'),
        	array('code' => '096', 'name' => 'Banco BMF'),
        	array('code' => '104', 'name' => 'Caixa Econômica Federal'),
        	array('code' => '107', 'name' => 'Banco BBM'),
        	array('code' => '116', 'name' => 'Banco Único'),
        	array('code' => '151', 'name' => 'Nossa Caixa'),
        	array('code' => '175', 'name' => 'Banco Finasa'),
        	array('code' => '184', 'name' => 'Banco Itaú BBA'),
        	array('code' => '204', 'name' => 'American Express Bank'),
        	array('code' => '208', 'name' => 'Banco Pactual'),
        	array('code' => '212', 'name' => 'Banco Matone'),
        	array('code' => '213', 'name' => 'Banco Arbi'),
        	array('code' => '214', 'name' => 'Banco Dibens'),
        	array('code' => '217', 'name' => 'Banco Joh Deere'),
        	array('code' => '218', 'name' => 'Banco Bonsucesso'),
        	array('code' => '222', 'name' => 'Banco Calyon Brasil'),
        	array('code' => '224', 'name' => 'Banco Fibra'),
        	array('code' => '225', 'name' => 'Banco Brascan'),
        	array('code' => '229', 'name' => 'Banco Cruzeiro'),
        	array('code' => '230', 'name' => 'Unicard'),
        	array('code' => '233', 'name' => 'Banco GE Capital'),
        	array('code' => '237', 'name' => 'Bradesco'),
        	array('code' => '241', 'name' => 'Banco Clássico'),
        	array('code' => '243', 'name' => 'Banco Stock Máxima'),
        	array('code' => '246', 'name' => 'Banco ABC Brasil'),
        	array('code' => '248', 'name' => 'Banco Boavista Interatlântico'),
        	array('code' => '249', 'name' => 'Investcred Unibanco'),
        	array('code' => '250', 'name' => 'Banco Schahin'),
        	array('code' => '252', 'name' => 'Fininvest'),
        	array('code' => '254', 'name' => 'Paraná Banco'),
        	array('code' => '263', 'name' => 'Banco Cacique'),
        	array('code' => '265', 'name' => 'Banco Fator'),
        	array('code' => '266', 'name' => 'Banco Cédula'),
        	array('code' => '300', 'name' => 'Banco de la Nación Argentina'),
        	array('code' => '318', 'name' => 'Banco BMG'),
        	array('code' => '320', 'name' => 'Banco Industrial e Comercial'),
        	array('code' => '356', 'name' => 'ABN Amro Real'),
        	array('code' => '341', 'name' => 'Itau'),
        	array('code' => '347', 'name' => 'Sudameris'),
        	array('code' => '351', 'name' => 'Banco Santander'),
        	array('code' => '353', 'name' => 'Banco Santander Brasil'),
        	array('code' => '366', 'name' => 'Banco Societe Generale Brasil'),
        	array('code' => '370', 'name' => 'Banco WestLB'),
        	array('code' => '376', 'name' => 'JP Morgan'),
        	array('code' => '389', 'name' => 'Banco Mercantil do Brasil'),
        	array('code' => '394', 'name' => 'Banco Mercantil de Crédito'),
        	array('code' => '399', 'name' => 'HSBC'),
        	array('code' => '409', 'name' => 'Unibanco'),
        	array('code' => '412', 'name' => 'Banco Capital'),
        	array('code' => '422', 'name' => 'Banco Safra'),
        	array('code' => '453', 'name' => 'Banco Rural'),
        	array('code' => '456', 'name' => 'Banco Tokyo Mitsubishi UFJ'),
        	array('code' => '464', 'name' => 'Banco Sumitomo Mitsui Brasileiro'),
        	array('code' => '477', 'name' => 'Citibank'),
        	array('code' => '479', 'name' => 'Itaubank (antigo Bank Boston)'),
        	array('code' => '487', 'name' => 'Deutsche Bank'),
        	array('code' => '488', 'name' => 'Banco Morgan Guaranty'),
        	array('code' => '492', 'name' => 'Banco NMB Postbank'),
        	array('code' => '494', 'name' => 'Banco la República Oriental del Uruguay'),
        	array('code' => '495', 'name' => 'Banco La Provincia de Buenos Aires'),
        	array('code' => '505', 'name' => 'Banco Credit Suisse'),
        	array('code' => '600', 'name' => 'Banco Luso Brasileiro'),
        	array('code' => '604', 'name' => 'Banco Industrial'),
        	array('code' => '610', 'name' => 'Banco VR'),
        	array('code' => '611', 'name' => 'Banco Paulista'),
        	array('code' => '612', 'name' => 'Banco Guanabara'),
        	array('code' => '613', 'name' => 'Banco Pecunia'),
        	array('code' => '623', 'name' => 'Banco Panamericano'),
        	array('code' => '626', 'name' => 'Banco Ficsa'),
        	array('code' => '630', 'name' => 'Banco Intercap'),
        	array('code' => '633', 'name' => 'Banco Rendimento'),
        	array('code' => '634', 'name' => 'Banco Triângulo'),
        	array('code' => '637', 'name' => 'Banco Sofisa'),
        	array('code' => '638', 'name' => 'Banco Prosper'),
        	array('code' => '643', 'name' => 'Banco Pine'),
        	array('code' => '652', 'name' => 'Itaú Holding Financeira'),
        	array('code' => '653', 'name' => 'Banco Indusval'),
        	array('code' => '654', 'name' => 'Banco A.J. Renner'),
        	array('code' => '655', 'name' => 'Banco Votorantim'),
        	array('code' => '707', 'name' => 'Banco Daycoval'),
        	array('code' => '719', 'name' => 'Banif'),
        	array('code' => '721', 'name' => 'Banco Credibel'),
        	array('code' => '734', 'name' => 'Banco Gerdau'),
        	array('code' => '735', 'name' => 'Banco Pottencial'),
        	array('code' => '738', 'name' => 'Banco Morada'),
        	array('code' => '739', 'name' => 'Banco Galvão de Negócios'),
        	array('code' => '740', 'name' => 'Banco Barclays'),
        	array('code' => '741', 'name' => 'BRP'),
        	array('code' => '743', 'name' => 'Banco Semear'),
        	array('code' => '745', 'name' => 'Banco Citibank'),
        	array('code' => '746', 'name' => 'Banco Modal'),
        	array('code' => '747', 'name' => 'Banco Rabobank International'),
        	array('code' => '748', 'name' => 'Banco Cooperativo Sicredi'),
        	array('code' => '749', 'name' => 'Banco Simples'),
        	array('code' => '751', 'name' => 'Dresdner Bank'),
        	array('code' => '752', 'name' => 'BNP Paribas'),
        	array('code' => '753', 'name' => 'Banco Comercial Uruguai'),
        	array('code' => '755', 'name' => 'Banco Merrill Lynch'),
        	array('code' => '756', 'name' => 'Banco Cooperativo do Brasil'),
        	array('code' => '757', 'name' => 'KEB'),
        );
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
