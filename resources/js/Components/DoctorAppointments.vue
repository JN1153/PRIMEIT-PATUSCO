<template>
    <div class="p-4">
      <el-button @click="resetDateFilter">Limpar Filtro (Data)</el-button>
      <el-button @click="resetTypeFilter">Limpar Filtro (Tipo)</el-button>
      <el-button @click="clearFilter">Limpar Todos os Filtros</el-button>
  
      <el-table ref="tableRef" :data="filteredAppointments">
        <el-table-column prop="client_name" label="Nome do Cliente" />
        <el-table-column prop="animal_name" label="Nome do Animal" />
        <el-table-column 
          prop="animal_type" 
          label="Tipo de Animal"
          sortable
          column-key="animal_type"
          :filters="animalTypeFilters"
          :filter-method="filterTag('animal_type')"
          filter-placement="bottom-end"
        />
        <el-table-column prop="age" label="Idade" />
        <el-table-column prop="symptoms" label="Sintomas" />
        <el-table-column 
          prop="appointment_date" 
          label="Data"
          sortable
          column-key="appointment_date"
          :filters="dateFilters"
          :filter-method="filterTag('appointment_date')"
          filter-placement="bottom-end"
        />
        <el-table-column prop="time_of_day" label="Período do Dia" />
        <el-table-column label="Ações">
        <template #default="{ row }">
          <el-button @click="editAppointment(row)" type="primary" size="small">Editar</el-button>
          <el-button 
            v-if="isRecepcionist" 
            @click="deleteAppointment(row.id)" 
            type="danger" 
            size="small"
          >
            Excluir
          </el-button>
        </template>
      </el-table-column>
      </el-table>
    </div>
  </template>
  
  <script lang="ts">
  import { defineComponent, ref, computed, onMounted } from 'vue';
  import type { TableInstance } from 'element-plus';
  
  interface Appointment {
    client_name: string;
    animal_name: string;
    animal_type: string;
    age: string;
    symptoms: string;
    appointment_date: string;
    time_of_day: string;
  }
  
  // Define o tipo das props
  export default defineComponent({
    props: {
      dataAppointments: {
        type: Array as () => Appointment[],
        required: true
        },
      userRole: {
        type: String,
        required: true
        }
    },
    setup(props) {
        const tableRef = ref<TableInstance | null>(null);
        console.log(props)
        const isRecepcionist = computed(() => props.userRole === 'receptionist');
  
        // Computed properties para filtros
        const animalTypeFilters = computed(() => {
            const types = new Set(props.dataAppointments.map(app => app.animal_type));
            return Array.from(types).map(type => ({
            text: type,
            value: type
            }));
        });
    
        const dateFilters = computed(() => {
            const dates = new Set(props.dataAppointments.map(app => app.appointment_date));
            return Array.from(dates).map(date => ({
            text: date,
            value: date
            }));
        });
    
        const filteredAppointments = computed(() => {
            return props.dataAppointments;
        });
    
        // Método para aplicar filtro na coluna
        const filterTag = (column: string) => (value: string, row: Appointment) => {
            return row[column as keyof Appointment] === value;
        };
    
        const resetDateFilter = () => {
            if (tableRef.value) {
            tableRef.value.clearFilter(['appointment_date']);
            }
        };
    
        const resetTypeFilter = () => {
            if (tableRef.value) {
            tableRef.value.clearFilter(['animal_type']);
            }
        };
    
        const clearFilter = () => {
            if (tableRef.value) {
            tableRef.value.clearFilter();
            }
        };
        const editAppointment = (appointment: Appointment) => {
            //TODO: Redirecionar para a página de edição de marcação
            console.log('Editar marcação:', appointment);
        };
        const deleteAppointment = async (appointmentId: number) => {
            console.log('Excluir marcação:', appointmentId);
        };
    
        return {
            tableRef,
            animalTypeFilters,
            dateFilters,
            filterTag,
            resetDateFilter,
            resetTypeFilter,
            clearFilter,
            filteredAppointments,
            editAppointment,
            deleteAppointment,
            isRecepcionist
        };
        }
    });
</script>
  
  <style scoped>
  /* Adicione estilos específicos se necessário */
  </style>
  