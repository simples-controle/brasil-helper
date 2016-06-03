<?php
namespace sururulab\BrasilHelper;

/**
* Brasil Helper é um projeto open source que empacota via pacote composer um poderoso
* helper de utilidades para quem desenvolve software para regionalização do Brasil.
* 
*/
class BrasilHelper
{

    /**
     * Valida CPF 
     * 
     * @author Luiz Otávio Miranda <contato@todoespacoonline.com/w> 
     * @param string $cpf O CPF com ou sem pontos e traço
     * @return bool True para CPF correto - False para CPF incorreto
     *
     */
    public static function checkCPF($cpf = false)
    {
        return self::valida_cpf($cpf);
    }



    /**
     * Valida CPF 
     * 
     * @author Luiz Otávio Miranda <contato@todoespacoonline.com/w> 
     * @param string $cpf O CPF com ou sem pontos e traço
     * @return bool True para CPF correto - False para CPF incorreto
     *
     */
    private function valida_cpf( $cpf = false ) {
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