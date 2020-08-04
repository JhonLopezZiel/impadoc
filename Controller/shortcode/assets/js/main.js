const App = new Vue({
	el:"#app",
	data: {
		step: 1,
		totalSteps: 4,
		errors: [],
		comboMaterial:{},
		resultTable:{},
		form: {
			tipo_superficie: null,
			tipo_acabado: null,
			actividad: null,
			medida: null,
			materiales: null,
		},
		styleObject: "width: 100%; "+
			"height: 20px; "+
			"background: #E3E3E3; "+
			"border-radius: 5px; "
	},
	//style="width: 100%; "
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
				if(this.step == 2){
					this.llenarComboMaterial();
				}	
			}			
		},
		sendStep:function(){
			this.step++;
			for(i in this.comboMaterial){
				console.log(this.comboMaterial[i].combo);
				if(this.comboMaterial[i].combo == this.form.materiales){
					this.resultTable = this.comboMaterial[i].data;
					break;
				}
	        }
		},
		llenarComboMaterial:function(){	
			if (this.step == 2) {				
				axios.get("http://localhost/famouscali/wp-content/plugins/calculator_ziel/controller/api/data_api.php?action=comboMaterial&tipo_superficie='"+this.form.tipo_superficie+"'&tipo_acabado='"+this.form.tipo_acabado+"'&actividad='"+this.form.actividad+"'")
				.then(response=>{
					this.jsonMaterial(response);
				});
			}			
		},
		jsonMaterial:function(response){
			const comboMaterial = localStorage.getItem("comboMaterial");
			
			if(comboMaterial){
				this.comboMaterial = JSON.parse(comboMaterial);
				return;
			}
			axios.get(response.data[0].url_json)
			.then(response=>{
				this.comboMaterial = response.data;
				localStorage.setItem("comboMaterial",JSON.stringify(response.data));
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
	}


}) 