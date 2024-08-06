<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;



class AppointmentController extends Controller
{
    public function index()
    {
        $userRole = Auth::user()->role;
        if (Auth::user()->isReceptionist()) {
            $appointments = Appointment::with('doctor')->get();
        } elseif (Auth::user()->isDoctor()) {
            $appointments = Appointment::where('doctor_id', Auth::id())
                                        ->orderBy('appointment_date')
                                        ->get();
        }

        return Inertia::render('Appointments/Index', [
            'appointments' => $appointments,
            'userRole' => $userRole
        ]);
    }

    public function storeClient(Request $request)
    {
        $data = $request->all();
        
        $validator = Validator::make($data, [
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email',
            'animal_name' => 'required|string|max:255',
            'animal_type' => 'required',
            'age' => 'required|integer',
            'symptoms' => 'required|string',
            'appointment_date' => 'required|date',
            'time_of_day' => 'required',
        ], [
            'client_name.required' => 'O nome do cliente é obrigatório',
            'cleint_email.required' => 'O email do cliente é obrigatório',
            'animal_name.required' => 'O nome do animal é obrigatório',
            'animal_type.required' => 'O tipo de animal é obrigatório',
            'age.required' => 'A idade é obrigatória',
            'symptoms.required' => 'Os sintomas são obrigatórios',
            'appointment_date.required' => 'A data da marcação é obrigatória',
            'time_of_day.required' => 'A período do dia é obrigatório',
        ]);
        $appointmentDate = Carbon::parse($request->appointment_date)->format('Y-m-d H:i:s');

        Appointment::create([
            'client_name' => $request->client_name,
            'client_email' => $request->client_email,
            'animal_name' => $request->animal_name,
            'animal_type' => $request->animal_type,
            'age' => $request->age,
            'symptoms' => $request->symptoms,
            'appointment_date' => $appointmentDate,
            'time_of_day' => $request->time_of_day,
        ]);

        return redirect()->route('welcome');
    }
    public function create()
    {
        if (!Auth::user()->isReceptionist()) {
            abort(403);
        }
        
        return Inertia::render('Appointments/Create', [
            'doctors' => User::where('role', 'doctor')->get(),
            'userRole' => Auth::user()->role
        ]);
    }

    public function store(Request $request, Appointment $appointment): RedirectResponse
    {
        Gate::authorize('create', $appointment);
        $data = $request->all();
        
        $validator = Validator::make($data, [
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email',
            'animal_name' => 'required|string|max:255',
            'animal_type' => 'required',
            'age' => 'required|integer',
            'symptoms' => 'required|string',
            'appointment_date' => 'required|date',
            'time_of_day' => 'required',
            'doctor_id' => 'nullable|exists:users,id',
        ], [
            'client_name.required' => 'O nome do cliente é obrigatório',
            'cleint_email.required' => 'O email do cliente é obrigatório',
            'animal_name.required' => 'O nome do animal é obrigatório',
            'animal_type.required' => 'O tipo de animal é obrigatório',
            'age.required' => 'A idade é obrigatória',
            'symptoms.required' => 'Os sintomas são obrigatórios',
            'appointment_date.required' => 'A data da marcação é obrigatória',
            'time_of_day.required' => 'A período do dia é obrigatório',
            'doctor_id.required' => 'O médico é obrigatório',
        ]);
        $appointmentDate = Carbon::parse($request->appointment_date)->format('Y-m-d H:i:s');
        Appointment::create([
            'client_name' => $request->client_name,
            'client_email' => $request->client_email,
            'animal_name' => $request->animal_name,
            'animal_type' => $request->animal_type,
            'age' => $request->age,
            'symptoms' => $request->symptoms,
            'appointment_date' => $appointmentDate,
            'time_of_day' => $request->time_of_day,
            'doctor_id' => $request->doctor_id, // Assuming you are passing doctor_id
        ]);
        return redirect()->route('appointments.index');
    }


    public function storeEdit(Request $request, Appointment $appointment): RedirectResponse
    {
        $appointment = Appointment::findOrFail($request->id);
        Gate::authorize('storeEdit', $appointment);

        $validator = Validator::make($request->all(), [
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email',
            'animal_name' => 'required|string|max:255',
            'animal_type' => 'required',
            'age' => 'required|integer',
            'symptoms' => 'required|string',
            'appointment_date' => 'required|date',
            'time_of_day' => 'required',
            'doctor_id' => 'nullable|exists:users,id',
        ], [
            'client_name.required' => 'O nome do cliente é obrigatório',
            'client_email.required' => 'O email do cliente é obrigatório',
            'animal_name.required' => 'O nome do animal é obrigatório',
            'animal_type.required' => 'O tipo de animal é obrigatório',
            'age.required' => 'A idade é obrigatória',
            'symptoms.required' => 'Os sintomas são obrigatórios',
            'appointment_date.required' => 'A data da marcação é obrigatória',
            'time_of_day.required' => 'A período do dia é obrigatório',
            'doctor_id.required' => 'O médico é obrigatório',
        ]);
        
        
        $appointmentDate = Carbon::parse($request->appointment_date)->format('Y-m-d H:i:s');
        $appointment->client_name = $request->client_name;
        $appointment->client_email = $request->client_email;
        $appointment->animal_name = $request->animal_name;
        $appointment->animal_type = $request->animal_type;
        $appointment->age = $request->age;
        $appointment->symptoms = $request->symptoms;
        $appointment->appointment_date = $appointmentDate;
        $appointment->time_of_day = $request->time_of_day;
        $appointment->doctor_id = $request->doctor_id; // Assuming you are passing doctor_id
        $appointment->save();

        return redirect()->route('appointments.index');
    }


    public function edit(Appointment $appointment)
    {
        if (!Auth::user()->isReceptionist() && Auth::id() !== $appointment->doctor_id) {
            abort(403);
        }

        return Inertia::render('Appointments/Edit', [
            'appointment' => $appointment,
            'userRole' => Auth::user()->role,
            'doctors' => User::where('role', 'doctor')->get()
        ]);
    }

    public function update(Request $request, Appointment $appointment)
    {   
    }

    public function destroy(Appointment $appointment)
    {
        if (!Auth::user()->isReceptionist()) {
            abort(403);
        }

        $appointment->delete();

        return to_route('appointments.index');
    }
}
