<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Services;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

final class ServicesController extends Controller
{
    public function __construct(private Services $services) {}

    public function index(Request $request): View|string
    {
        if ($request->ajax()) {
            if ($request->has('create')) {
                return view('components.admin.services.cad-edit', ['service' => null])->render();
            }
            $serviceId = $request->query('service_id') ?? $request->query('service');
            if ($serviceId) {
                $service = $this->services->findOrFail($serviceId);

                return view('components.admin.services.cad-edit', compact('service'))->render();
            }
        }

        $services = $this->services->findAll();
        $selectedService = $services->first();

        return view('pages.admin.services.index', compact('services', 'selectedService'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'slug' => \Illuminate\Support\Str::slug($request->name ?? ''),
        ]);

        $data = $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string',
            'description' => 'required|string',
            'features' => 'required|string',
            'tags' => 'required|string',
            'sort_order' => 'required|integer|min:1',
        ]);

        $data['status'] = (int) $request->input('status', 0);

        if ($request->has('icon')) {
            $data['icon'] = $request->input('icon');
        }

        if (isset($data['features']) && is_string($data['features'])) {
            $data['features'] = array_map('trim', explode(',', $data['features']));
        }

        if (isset($data['tags']) && is_string($data['tags'])) {
            $data['tags'] = array_map('trim', explode(',', $data['tags']));
        }

        try {
            $this->services->create($data);

            return redirect()->route('admin.services.index')->with('success', 'Serviço criado com sucesso!');
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao salvar serviço!');
        }
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->merge([
            'slug' => \Illuminate\Support\Str::slug($request->name ?? ''),
        ]);

        $data = $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string',
            'description' => 'required|string',
            'features' => 'required|string',
            'tags' => 'required|string',
            'sort_order' => 'required|integer|min:1',
        ]);

        $data['status'] = (int) $request->input('status', 0);

        if ($request->has('icon')) {
            $data['icon'] = $request->input('icon');
        }

        if (isset($data['features']) && is_string($data['features'])) {
            $data['features'] = array_map('trim', explode(',', $data['features']));
        }

        if (isset($data['tags']) && is_string($data['tags'])) {
            $data['tags'] = array_map('trim', explode(',', $data['tags']));
        }

        try {
            $service = $this->services->findOrFail($id);
            $service->update($data);

            return redirect()->route('admin.services.index')->with('success', 'Serviço atualizado com sucesso!');
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao atualizar serviço!');
        }
    }

    public function unpublish(Request $request, $id): RedirectResponse
    {
        try {
            $service = $this->services->findOrFail($id);
            $service->update(['status' => ! $request->status]);

            return redirect()->route('admin.services.index')->with('success', 'Serviço despublicado com sucesso!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error', 'Erro ao despublicar serviço!');
        }
    }
}
