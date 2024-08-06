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
            <el-form-item label="Médico" prop="doctors" v-if="userRole === 'receptionist'">
                <el-select v-model="form.doctor_id" placeholder="Selecione o médico">
                    <el-option v-for="doctor in doctorsData" :label="doctor.name" :value="doctor.id" />
                </el-select>
            </el-form-item>
            <el-form-item>
                <button v-if="isEdit" type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</button>
                <button v-if="!isEdit" type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Criar</button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref, watch, computed } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

   export default defineComponent({
        props: {
            doctorsData: {
                type: Object,
                required: false
                },
            userRole: {
                type: String,
                required: false
            },
            appointment: Object,
            isEdit:{
                type: Boolean,
                default: false
            },
            isClient: {
                type: Boolean,
                default: false
            }
        },
        setup(props) {
            // Initialize form data
            const { props: pageProps } = usePage()
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

            const resetForm = () => {
                form.value = {
                    client_name: '',
                    client_email: '',
                    animal_name: '',
                    animal_type: '',
                    age: null,
                    symptoms: '',
                    appointment_date: '',
                    time_of_day: '',
                    doctor_id: null,
                };
                formRef.value.clearValidate();
            };

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
                    { required: true, message: 'Tipo de animal é obrigatório', trigger: 'blur' }
                ],
                age: [
                    { required: true, message: 'Idade é obrigatória', trigger: 'change' },
                    { type: 'number', message: 'Idade deve ser um número', trigger: 'blur' }
                ],
                symptoms: [
                    { required: true, message: 'Sintomas são obrigatórios', trigger: 'blur' }
                ],
                appointment_date: [
                    { required: true, message: 'Data da marcação é obrigatória', trigger: 'blur' }
                ],
                time_of_day: [
                    { required: true, message: 'Período do dia é obrigatório', trigger: 'blur' }
                ],
                };

            const formRef = ref(null);
            const isReceptionist = computed(() => pageProps.useRole === 'receptionist');
            const doctors = ref(pageProps.doctors || []);

            watch(() => props.appointment, (newValue) => {
                if (newValue) {
                    form.value = { ...newValue };
                }
            }, { immediate: true });
            
            const submitForm = () => {
                formRef.value?.validate((valid) => {
                    if (valid) {
                        const requestData = { ...form.value };
                        if(!props.isClient){
                            if(props.isEdit){
                                router.post(route('appointments.storeEdit'), requestData)
                            }else{
                                router.post(route('appointments.store'), requestData);
                            }
                        }else{
                            router.post(route('client.appointment.store'), requestData);
                            resetForm();
                        }
                    } else {
                        console.log('Validation Error');
                        return false;
                    }
                });
            };
            const cancelEdit = () => {
                router.visit(route('appointments.index'));
            };
            return {
                form,
                rules,
                formRef,
                submitForm,
                cancelEdit,
                isReceptionist,
                doctors
            };
        },
        });
</script>