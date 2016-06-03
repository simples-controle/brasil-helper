# BrasilHelper

BrasilHelper é um projeto open source que empacota via pacote composer um poderoso helper de utilidades para quem desenvolve software para regionalização do Brasil.

## Como instalar

BrasilHelper é um pacote PHP distribuido via composer, então para instalar rode o comando abaixo:

 
```php
php composer require sururulab/brasil-helper
```

Ou adicione a linha abaixo ao seu composer.json na seção require.  

```php
"webvimark/module-user-management": "1.0.4"
```

e rode:

```php
php composer update
```

## Como Usar

### Exemplos rápidos

```php
<?php
use sururulab\BrasilHelper\BrasilHelper;

echo BrasilHelper::checkCNPJ('23.419.212/0001-03');

echo BrasilHelper::checkCPF('635.850.266-21');

echo BrasilHelper::checkIE('0136042371217', 'AC');

echo BrasilHelper::estados();
```

### Exemplo teste CNPJ válido

```php
<?php
use sururulab\BrasilHelper\BrasilHelper;

if(BrasilHelper::checkCNPJ('23.419.212/0001-03')){
	echo 'Válido';
}else{
	echo 'Não Válido';
}
```

### Exemplo teste CPF válido

```php
<?php
use sururulab\BrasilHelper\BrasilHelper;

if(BrasilHelper::checkCPF('635.850.266-21')){
	echo 'Válido';
}else{
	echo 'Não Válido';
}
```

## Contribua

Pull Request's são muito bem vindos!


