document.addEventListener('DOMContentLoaded',function(){
	const formulario=document.getElementById('form');
	const loader=document.getElementById('loader');
	formulario.addEventListener('submit',function(){
		loader.style.display='block';
	});

	const nao=document.getElementsByClassName('bnao');
	if (nao.length > 0) {
		nao[0].addEventListener('click',function(){
			loader.style.display='block';
		});
	}

	const telefone=document.getElementById('telefone');
	if (telefone) {
		telefone.addEventListener('input',function(e){
			let valor=e.target.value.replace(/\D/g,'');
			valor= valor.substring(0,11);
			let numeroformatado='';

			if (valor.length > 0) numeroformatado += '(' + valor.substring(0, 2);
			if (valor.length >= 3) numeroformatado += ')';
			if (valor.length > 10) {
				numeroformatado += valor.substring(2, 7);
				if (valor.length >= 8) {
					numeroformatado += '-' + valor.substring(7, 11);
				}
			}else if (valor.length > 6) {
				numeroformatado += valor.substring(2, 6);
				numeroformatado += '-' + valor.substring(6, 10);
			}else if (valor.length > 2) {
				numeroformatado += valor.substring(2);
			}

			e.target.value=numeroformatado;

		});
	}

	const cpf = document.getElementById('cpf');

	if (cpf) {
		cpf.addEventListener('input', function () {

			let valor = cpf.value;

       		valor = valor.replace(/\D/g, '');

        	valor = valor.substring(0, 11);

        	valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
			valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
			valor = valor.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

			cpf.value = valor;
		});
	}

	const cnpj = document.getElementById('cnpj');

	if (cnpj) {
		cnpj.addEventListener('input', function () {

			let valor = cnpj.value;

        	valor = valor.replace(/\D/g, '');

        	valor = valor.substring(0, 14);

        valor = valor.replace(/^(\d{2})(\d)/, '$1.$2');
        valor = valor.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
        valor = valor.replace(/\.(\d{3})(\d)/, '.$1/$2');
        valor = valor.replace(/(\d{4})(\d{1,2})$/, '$1-$2');

			cnpj.value = valor;
		});
	}


	const valor = document.getElementById('valor');
	if (valor) {
		valor.addEventListener('input', function(e) {
	        // Remove tudo que não for número, ponto ou vírgula
			let v = e.target.value.replace(/[^\d,. ]/g, '');

	        // Transforma a primeira vírgula em ponto e remove as demais
			v = v.replace(',', '.');
			const partes = v.split('.');
			if (partes.length > 2) {
				v = partes[0] + '.' + partes.slice(1).join('');
			}

	        // Limita o tamanho total em 7 caracteres (incluindo o ponto)
			v = v.substring(0, 7);

			e.target.value = v;
		});
	}


	

});
