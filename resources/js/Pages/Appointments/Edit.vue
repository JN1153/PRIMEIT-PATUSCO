<script setup>
import AppointmentForm from '@/Components/AppointmentForm.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
  doctors: Object,
  appointment: Object,
  userRole: String
});
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
      <template #header>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Marcação</h2>
            <Link :href="route('appointments.create')" v-if="userRole === 'receptionist'" class="bg-slate-300 px-4 py-2 rounded-lg hover:bg-slate-700 focus:bg-slate-700 hover:text-white focus:text-white">Adicionar Marcação</Link>
      </template>

      <div class="py-12">
          <div class="mx-auto sm:px-6 lg:px-8">
              <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <AppointmentForm :appointment="appointment" :isEdit="true" :userRole="userRole" :doctorsData="doctors" />
              </div>
          </div>
      </div>
  </AuthenticatedLayout>
</template>