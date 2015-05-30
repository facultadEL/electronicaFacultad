<script>
		var dataDictionary = [];

		function setData(dataToPush){
			dataDictionary.push(dataToPush);
		}

		function validateData(){

			var mail, pass, loginCheck;
			var exito = 0;
			mail = $('#email').val().toLowerCase();
			pass = $('#password').val();
			loginCheck = mail+'/--/'+pass;

			for(var i = 0; i < dataDictionary.length; i++)
			{
				var vData = dataDictionary[i].split('/--/');
				if(vData[0] == mail)
				{

					if(pass == disencrypt(vData[1]))
					{
						exito = 1;
						break;
					}
				}
			}

			if(exito == 1)
			{
				return true;
			}
			else
			{
				for (var i = 0; i < dataDictionary.length; i++) {
					vString = dataDictionary[i].split('/--/');

					if (vString[0] == mail){
						alert("La contraseña es incorrecta");
						$('#password').val("");
						$('#password').focus();
						return false;
					}else{
						alert("Los datos ingresados son incorrectos");
						$('#email').val("");
						$('#password').val("");
						$('#email').focus();
						return false;
					}
				}
			}
		}
	</script>