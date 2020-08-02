const App = new Vue({
	el:"#app",
	data: {
		step: 1,
		totalSteps: 4,
		errors: [],
		comboMaterial:{},
		form: {
			tipo_superficie: null,
			tipo_acabado: null,
			actividad: null,
			medida: null,
			materiales: null,
		}
	},
	computed:{
		materialsOptions(){
			return Object.values(this.comboMaterial);
		}
	},
	methods: {
		prevStep:function(){
			this.step--;
		},
		nextStep:function(){
			this.errors = '';
			if(this.validacionRequired()){
				this.errors += 'Los Campos con Asterico(*) son Obligatorio.'; 
				return false;
			}else{
				this.step++;
				if(this.step == 3){
					this.llenarComboMaterial();
				}	
			}			
		},
		sendStep:function(){
			alert("Confirmado");	
		},
		llenarComboMaterial:function(){
			const material = localStorage.getItem("comboMaterial");

			if(material){
				this.comboMaterial = JSON.parse("comboMaterial");
				return;
			}
			axios.get('')
			.then(response=>{
				this.comboMaterial = response.data.data;
				localStorage.setItem("comboMaterial",JSON.stringify(response.data.data));
				consolte.log(response);
			});
		},
		validacionRequired:function(){
			var validate = false;
			if(this.step == 1){
				if(this.form.tipo_superficie == null || 
					this.form.tipo_acabado == null ||
					this.form.actividad == null){
					this.validate = true;
				}
			}else if(this.step == 2){
				if(!this.form.medida){
					this.validate = true;
				}
			}else if(this.step == 3){
				if(!this.form.materiales){
					this.validate = true;
				}
			}
			return this.validate;
		}
	},
	mounted(){
		//alert("Hola mundo");
	}


}) 