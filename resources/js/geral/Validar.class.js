class Validar {

	static json(string){

		try {
			JSON.parse(string);
		} catch (e) {
			return false;
		}

		return true;

	}

	static valida_nome(string){

		let expressao = /^([A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ.'´ ]{3,250})$/;
		
		if(expressao.test(string) == true){
			return false;
		}else{
			return true;
		}

	}

	static valida_parenteses(string){

		let expressao = /^([A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ() ]{3,250})$/;
		
		if(expressao.test(string) == true){
			return false;
		}else{
			return true;
		}

	}
    
    static validarCPF (strCPF) {
        var i, j, soma, cpf;
        
        cpf = strCPF.replace(/\D/g, '');
        if (!/^(?!^(\d)\1+$)\d{11}$/.test(cpf)) {
            return false;
        }
        
        for (i = 9; i < 11; i++) {
            for (soma = 0, j = 0; j < i; j++) {
            soma += parseInt(cpf.charAt(j)) * ((i + 1) - j);
            }
            soma = ((10 * soma) % 11) % 10;
            if (parseInt(cpf.charAt(j)) !== soma) {
            return false;
            }
        }
        
        return true;
    }

    static validarCnpj(cnpj) {

        var cnpj = cnpj.replace(/[^\d]+/g,'');

        if(cnpj == '') return false;
    
        if (cnpj.length != 14)
            return false;
    
        if (cnpj == "00000000000000" ||
            cnpj == "11111111111111" ||
            cnpj == "22222222222222" ||
            cnpj == "33333333333333" ||
            cnpj == "44444444444444" ||
            cnpj == "55555555555555" ||
            cnpj == "66666666666666" ||
            cnpj == "77777777777777" ||
            cnpj == "88888888888888" ||
            cnpj == "99999999999999")
            return false;
    
        var size = cnpj.length - 2
        var numbers = cnpj.substring(0,size);
        var digits = cnpj.substring(size);
        var sum = 0;
        var pos = size - 7;
        for (var i = size; i >= 1; i--) {
            sum += numbers.charAt(size - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        var result = sum % 11 < 2 ? 0 : 11 - sum % 11;
        if (result != digits.charAt(0))
            return false;
    
        size = size + 1;
        numbers = cnpj.substring(0,size);
        sum = 0;
        pos = size - 7;
        for (i = size; i >= 1; i--) {
            sum += numbers.charAt(size - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        result = sum % 11 < 2 ? 0 : 11 - sum % 11;
        if (result != digits.charAt(1))
            return false;
    
        return true;
    }

}