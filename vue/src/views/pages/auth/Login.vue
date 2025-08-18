<script setup>
import FloatingConfigurator from '@/components/FloatingConfigurator.vue';
import http from '@/service/http';
import { reactive, ref } from 'vue';

import { useToast } from 'primevue/usetoast';
const toast = useToast();

const email = ref('');
const password = ref('');
const checked = ref(false);
const errors = reactive({'errors': []});

function sendLogin(event){
    event.preventDefault();
    toast.removeAllGroups();
    http.post('auth',{
        'email':email.value,
        'password':password.value
    }).then(response => {
        window.location.href = '/prestadores';
    }).catch(error => {
        errors.errors = []; 
        if(error.status == 401){
            toast.add({
                severity: 'warn',
                summary: 'Alerta',
                detail: 'E-mail ou senha incorretos',
            });
        }else{
            errors.errors = error.response.data.errors;
        }
    });
}

</script>

<template>
    <Toast />
    <FloatingConfigurator />
    <div class="bg-surface-50 dark:bg-surface-950 flex items-center justify-center min-h-screen min-w-[100vw] overflow-hidden">
        <div class="flex flex-col items-center justify-center">
            <div style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, var(--primary-color) 10%, rgba(33, 150, 243, 0) 30%)">
                <form id="form" class="w-full bg-surface-0 dark:bg-surface-900 py-20 px-8 sm:px-20" method="post" v-on:submit="sendLogin"  style="border-radius: 53px">
                    <div class="text-center mb-8">
                        <div class="text-surface-900 dark:text-surface-0 text-3xl font-medium mb-4">Infornet</div>
                        <span class="text-muted-color font-medium">Faça o login para continuar</span>
                    </div>
                    <div>
                        <div class="flex flex-col">
                            <label for="email1" class="block text-surface-900 dark:text-surface-0 text-xl font-medium mb-2">E-mail</label>
                            <InputText id="email1" name="email" type="text" placeholder="E-mail" class="w-full md:w-[30rem] " v-model="email" />
                            <em v-if="errors.errors.email" class="error">{{ errors.errors.email[0] }}</em>
                        </div>
                        <div class="flex flex-col mt-8">
                            <label for="password1" class="block text-surface-900 dark:text-surface-0 font-medium text-xl mb-2">Senha</label>
                            <Password id="password1" name="password" v-model="password" placeholder="Senha" :toggleMask="true"  fluid :feedback="false"></Password>
                            <em v-if="errors.errors.password" class="error">{{ errors.errors.password[0] }}</em>
                        </div>
                        <Button type="submit" label="Login" class="w-full mt-8" ></Button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped>
.pi-eye {
    transform: scale(1.6);
    margin-right: 1rem;
}

.pi-eye-slash {
    transform: scale(1.6);
    margin-right: 1rem;
}
.error{
        color:#FF6961;
}
</style>
