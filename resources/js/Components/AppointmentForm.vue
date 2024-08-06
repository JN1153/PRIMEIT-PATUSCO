<template>
    <div class="p-4">
        <el-form :model="form" ref="formRef" :rules="rules" label-width="240px" @submit.prevent="submitForm">
            <el-form-item label="Nome do Cliente" prop="client_name">
                <el-input v-model="form.client_name" />
            </el-form-item>
            <el-form-item label="Email do Cliente" prop="client_email">
                <el-input v-model="form.client_email" />
            </el-form-item>
            <el-form-item label="Nome do Animal" prop="animal_name">
                <el-input v-model="form.animal_name" />
            </el-form-item>
            <el-form-item label="Tipo de Animal" prop="animal_type">
                <el-select v-model="form.animal_type" placeholder="Selecione o tipo">
                <el-option label="Cão" value="cão" />
                <el-option label="Gato" value="gato" />
                <el-option label="Tartaruga" value="Tartaruga" />
                <el-option label="Pato" value="Pato" />
                <el-option label="Galinha" value="Galinha" />
                </el-select>
            </el-form-item>
            <el-form-item label="Idade" prop="age">
                <el-input-number :min="1" :max="70" v-model="form.age"  />
            </el-form-item>
            <el-form-item label="Sintomas" prop="symptoms">
                <el-input type="textarea" v-model="form.symptoms" />
            </el-form-item>
            <el-form-item label="Data" prop="appointment_date">
                <el-date-picker
                v-model="form.appointment_date"
                type="date"
                placeholder="Selecione a data"
                />
            </el-form-item>
            <el-form-item label="Período do Dia" prop="time_of_day">
                <el-select v-model="form.time_of_day" placeholder="Selecione o período">
                    <el-option label="Manhã" value="Manhã" />
                    <el-option label="Tarde" value="Tarde" />
                </el-select>
            </el-form-item>
            <el-form-item label="Médico" prop="doctors">
                <el-select v-model="form.doctor_id" placeholder="Selecione o médico">
                    <el-option v-for="doctor in doctors" :label="doctor.name" :value="doctor.id" />
                </el-select>
            </el-form-item>
            <el-form-item>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Criar</button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref, reactive } from 'vue';
import { router } from '@inertiajs/vue3';
   export default defineComponent({
        props: {
            doctorsData: {
                type: Object,
                required: true
                },
        },
        setup(props) {
            // Initialize form data
            const form = ref({
                client_name: '',
                client_email: '',
                animal_name: '',
                animal_type: '',
                age: '',
                symptoms: '',
                appointment_date: '',
                time_of_day: '',
                doctor_id: null
            });

            const rules = {
                client_name: [
                    { required: true, message: 'Nome do cliente é obrigatório', trigger: 'blur' }
                ],
                client_email: [
                    { required: true, message: 'Email do cliente é obrigatório', trigger: 'blur' },
                    { type: 'email', message: 'Email do cliente é inválido', trigger: 'blur' }
                ],
                animal_name: [
                    { required: true, message: 'Nome do animal é obrigatório', trigger: 'blur' }
                ],
                animal_type: [
                    { required: true, message: 'Tipo de animal é obrigatório', trigger: 'change' }
                ],
                age: [
                    { required: true, message: 'Idade é obrigatória', trigger: 'change' },
                    { type: 'number', message: 'Idade deve ser um número', trigger: 'blur' }
                ],
                symptoms: [
                    { required: true, message: 'Sintomas são obrigatórios', trigger: 'blur' }
                ],
                appointment_date: [
                    { required: true, message: 'Data da marcação é obrigatória', trigger: 'change' }
                ],
                time_of_day: [
                    { required: true, message: 'Período do dia é obrigatório', trigger: 'change' }
                ],
                };

            const formRef = ref(null);

            // Form submission handler
            const submitForm = () => {
                formRef.value?.validate((valid) => {
                    if (valid) {
                        router.post(route('appointments.store'), form.value);
                    } else {
                        console.log('Erro na validação');
                        return false;
                    }
                });
                };
            return {
                form,
                rules,
                formRef,
                submitForm,
                doctors: props.doctorsData
            };
        },
        });
</script>