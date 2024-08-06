<template>
    <div>
      <h1>Edit Appointment</h1>
      <form @submit.prevent="submit">
        <input v-model="form.client_name" placeholder="Client Name" required />
        <input v-model="form.email" type="email" placeholder="Email" required />
        <input v-model="form.animal_name" placeholder="Animal Name" required />
        <select v-model="form.animal_type" required>
          <option value="cão">Dog</option>
          <option value="gato">Cat</option>
        </select>
        <input v-model="form.age" type="number" placeholder="Age" required />
        <textarea v-model="form.symptoms" placeholder="Symptoms" required></textarea>
        <input v-model="form.appointment_date" type="date" required />
        <select v-model="form.time_of_day" required>
          <option value="morning">Morning</option>
          <option value="afternoon">Afternoon</option>
        </select>
        <select v-model="form.doctor_id">
          <option v-for="doctor in doctors" :key="doctor.id" :value="doctor.id">{{ doctor.name }}</option>
        </select>
        <button type="submit">Save</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      appointment: Object,
      doctors: Array
    },
    data() {
      return {
        form: {
          client_name: this.appointment.client_name,
          email: this.appointment.email,
          animal_name: this.appointment.animal_name,
          animal_type: this.appointment.animal_type,
          age: this.appointment.age,
          symptoms: this.appointment.symptoms,
          appointment_date: this.appointment.appointment_date,
          time_of_day: this.appointment.time_of_day,
          doctor_id: this.appointment.doctor_id
        }
      }
    },
    methods: {
      async submit() {
        await fetch(`/appointments/${this.appointment.id}`, {
          method: 'PUT',
          body: JSON.stringify(this.form)
        });
        this.$inertia.visit('/appointments');
      }
    }
  }
  </script>
  