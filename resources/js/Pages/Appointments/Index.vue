<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Marcações" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Marcações</h2>
              <Link :href="route('appointments.create')" v-if="userRole === 'receptionist'" class="bg-slate-300 px-4 py-2 rounded-lg hover:bg-slate-700 focus:bg-slate-700 hover:text-white focus:text-white">Adicionar Marcação</Link>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                  <DoctorAppointments :dataAppointments="appointments" :userRole="userRole" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
  
<script>
import { defineComponent, ref, onMounted } from 'vue';
import DoctorAppointments from '@/Components/DoctorAppointments.vue';

export default defineComponent({
  components: {
    DoctorAppointments
  },
  props: {
    appointments: Array,
    userRole: String
  }
});
</script>
  