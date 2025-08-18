<script setup>
import Loader from '@/components/Loader.vue';
import http from '@/service/http';
import { onMounted, reactive, ref } from 'vue';

import { useToast } from 'primevue/usetoast';
const toast = useToast();

//TODO: Ver tempo do jwt
const servicos = reactive({'servicos':[]});
document.title = 'Listagem de Usuários';
const servico = ref(null);
const enderecos = reactive({'enderecos':[]});
const errors = reactive({'errors': []});
const participants = reactive({participants: null});
const qtd = ref(10);
const qtdOptions = reactive([10,20,50,100]);
const orderOptions = reactive([
    {id:0,title:'Selecione'},
    {id:1,title:'Valor Total'},
    {id:2,title:'Distância Total'},
    {id:3,title:'Status'}
]);
const order = ref({id:0,title:'Selecione'});
const situacao = ref();
const optionsSituacao = [
    {'nome':'Selecione', value:0},
    {'nome':'Online', value:1},
    {'nome':'Offline', value:2},
];
const estado = ref('');
const estados = reactive({estados:[]});

const cidade = ref('');
const cidades = reactive({cidades:[]});



onMounted(()=>{
    participants.participants = null;
    http.get('servico').then(response => {
        servicos.servicos = response.data;
    }).catch(error => {
        servicos.servicos = null;
        if(error.status == 401){
            window.location.href = '/login';
            return;
        }
    });
     http.get('getEnderecosDisponiveis').then(response => {
        enderecos.enderecos = response.data;
        if(!servico.value){
            estados.estados = Object.values(response.data.ufs)[0];
            cidades.cidades = Object.values(response.data.cidades)[0];
        }
        else{
            estados.estados = response.data.cidades[servico.value.id];
            cidades.cidades = response.data.cidades[servico.value.id];
        }
        
    }).catch(error => {
        servicos.servicos = null;
        if(error.status == 401){
            window.location.href = '/login';
            return;
        }
    });
});
function updateUf(){
    estados.estados = enderecos.enderecos.ufs[servico.value.id];
    cidades.cidades = enderecos.enderecos.cidades[servico.value.id];
    cidade.value = '';
    estado.value = '';
}
function buscarPrestador(){
    event.preventDefault();
    toast.removeAllGroups();
    const formData = new FormData(document.getElementById('form'));
    if(servico.value){
        formData.append('id_servico',servico.value.id);
    }
    if(order.value){
        formData.append('order',parseInt(order.value.id));
    }
    if(estado.value){
        formData.append('filtro.estado',estado.value.sigla);
    }
    if(cidade.value){
        formData.append('filtro.cidade',cidade.value);
    }
    if(situacao.value){
        formData.append('filtro.situacao',situacao.value);
    }
    formData.append('qtd',qtd.value);
    errors.errors = [];
    participants.participants = [];
    http.post('buscarPrestadores', formData).then(response => {
        if(response.data.length == 0){
            participants.participants = null;
        }else{
            participants.participants = response.data;
        }
        
    }).catch(error => {
        if(error.status == 502){
            
            toast.add({
                severity: 'error',
                summary: 'Alerta',
                detail: 'Não foi possível completar a solicitação',
            });
        }
        if(error.response.data.errors)
        {
            errors.errors = error.response.data.errors;
        }
        participants.participants= null;
        
    });
}

</script>
<template>
    <Fluid>
        <form class="flex" v-on:submit="buscarPrestador" id="form">
            <div class="card flex flex-col gap-4 w-full grid" >
                <h1>Pesquisar prestador</h1>
                <Fluid class="flex flex-wrap flex-col xl:flex-row items-start gap-4"style="max-width: 950px">
                    <div class="flex flex-col col-span-4 md:flex-row gap-4 flex-1">
                        <div class="flex col-span-4 flex-wrap gap-2 w-full">
                            <label for="id_servico">Serviço*</label>
                            <Select id="id_servico" v-model="servico" :options="servicos.servicos" optionLabel="nome"  @change="updateUf" name="id_servico" placeholder="Selecione" />
                            <em v-if="errors.errors.id_servico" class="error">{{ errors.errors.id_servico[0] }}</em>
                        </div>
                    </div>
                    <div class="flex flex-col col-span-4 md:flex-row gap-4">
                        <div class="flex flex-wrap gap-2 w-full">
                            <label for="endereco_origem">Endereço de origem*</label>
                            <InputText id="endereco_origem"  :class="errors.errors.endereco_origem ? 'p-invalid' : ''" name="endereco_origem" autocomplete="off"  type="text" />
                            <em v-if="errors.errors.endereco_origem" class="error">{{ errors.errors.endereco_origem[0] }}</em>
                        </div>
                    </div>
                    <div class="flex flex-col col-span-4 md:flex-row gap-4">
                        <div class="flex flex-wrap gap-2 w-full">
                            <label for="endereco_destino">Endereço de destino*</label>
                            <InputText id="endereco_destino"  :class="errors.errors.endereco_destino ? 'p-invalid' : ''" name="endereco_destino" autocomplete="off"  type="text" />
                            <em v-if="errors.errors.endereco_destino" class="error">{{ errors.errors.endereco_destino[0] }}</em>
                        </div>
                    </div>
                </Fluid>
                <Fluid class="flex gap-4 flex-wrap flex-col xl:flex-row  ">
                    <div class="flex flex-col md:flex-row gap-4 flex-1">
                        <div class="flex flex-wrap gap-2 w-full">
                            <label for="uf">UF</label>
                            <Select id="uf" v-model="estado" :options="estados.estados" optionLabel="nome" name="uf" placeholder="Selecione" />
                            <em v-if="errors.errors.uf" class="error">{{ errors.errors.uf[0] }}</em>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex flex-wrap gap-2 w-full">
                            <label for="cidade">Cidade</label>
                            <Select id="cidade" v-model="cidade" :options="cidades.cidades"  placeholder="Selecione" />
                            <em v-if="errors.errors.cidade" class="error">{{ errors.errors.cidade[0] }}</em>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-4 ">
                        <div class="flex flex-wrap gap-2 w-full">
                            <label for="status">Status</label>
                            <Select id="status" v-model="situacao" :options="optionsSituacao" optionLabel="nome" optionValue="value" name="id_servico" placeholder="Selecione" />
                            <em v-if="errors.errors.status" class="error">{{ errors.errors.status[0] }}</em>
                        </div>
                    </div>
                </Fluid>
                <div>
                    <Button type="submit" style="width:200px">Pesquisar</Button>
                </div>
            </div>
        </form>
    </Fluid>
    
        <div  class="card mt-5" v-if="participants.participants != null">
            <h1>Prestadores</h1> 
        
                <div class="flex flex-row gap-4">
                    <div class="flex flex-col gap-2 items-start">
                        <label>Quantidade</label>
                        <Select v-model="qtd" v-on:change="buscarPrestador" :options="qtdOptions" />
                    </div>
                    <div class="flex flex-col gap-2 items-start">
                        <label>Ordernar por:</label>
                        <Select v-model="order" v-on:change="buscarPrestador" :options="orderOptions" optionLabel="title" />
                    </div>
                </div>
    
            <template v-if="participants.participants && participants.participants.length > 0">
                <DataTable :value="participants.participants" stripedRows  scrollable scrollHeight="400px" class="mt-6">
                    <Column field="nome" header="Nome" style="min-width: 250px" class="font-bold"></Column>
                    <Column field="valor_saida" header="Valor Saída" style="min-width: 125px" class="font-bold"></Column>
                    <Column field="valor_km_excedente" header="Valor KM Excedente" style="min-width: 125px" class="font-bold"></Column>
                    <Column field="km_saida" header="KM Saída" style="min-width: 125px" class="font-bold"></Column>
                    <Column field="valor_total" header="Valor Total" style="min-width: 125px" class="font-bold"></Column>
                    <Column field="distancia_total" header="Distância Total" style="min-width: 125px" class="font-bold"></Column>
                     <Column field="acoes" header="Status" style="min-width: 200px">
                    <template #body="{ data }">
                        <div class="flex flex-col gap-2">
                            <template v-if="data.status == 'Online'">
                                <Button class="font-bold p-button p-component p-button-success"> Online</Button>
                            </template>
                            <template v-else>
                                <Button class="font-bold p-button p-component p-button-danger"> Offline</Button>                                
                            </template>
                        </div>
                    </template>
                    </Column>
                </DataTable>
            </template>
            <template v-else-if="participants.participants == null">
                
            </template>
            <template v-else-if="participants.participants == []">
                <h3 class="text-center text-gray-500">Não foram encontrados prestadores</h3>
            </template>
            <template v-else>
                <Loader/>
            </template>
        </div>
    
</template>  
<style scoped>
.error{
    color:#FF6961;
}
.bounce-item-enter-active {
  animation: bounce-in 1s ;
  animation-fill-mode: backwards;
}
.bounce-leave-from, .bounce-item-leave-active {
    display: none;
}
@keyframes bounce-in {
  0% {
    transform: scale(0);
  }
  50% {
    transform: scale(1.1);
  }
  100% {
    transform: scale(1);
  }
}
@keyframes bounce-out {
  0% {
    transform: scale(1);
  }

  100% {
    transform: scale(1);
  }
}
</style>