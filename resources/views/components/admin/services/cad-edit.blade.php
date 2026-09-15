<aside class="card border border-light-subtle bg-white shadow-sm h-100 rounded-3 d-flex flex-column">
  <form action="{{ isset($service) ? route('admin.services.update', $service->id) : route('admin.services.store') }}"
    method="POST" class="d-flex flex-column h-100">
    @csrf
    @if (isset($service))
      @method('PUT')
    @endif

    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3 px-4">
      <h5 class="mb-0 fs-6 fw-bold text-dark d-flex align-items-center gap-2" style="font-size: 14px !important;">
        <i class="bi bi-pencil-square text-primary"></i> {{ isset($service) ? 'Editar Serviço' : 'Adicionar Serviço' }}
      </h5>
      <button type="button" class="btn-close" style="font-size: 10px;"></button>
    </div>

    <div class="card-body px-4 py-4 d-flex flex-column gap-4 overflow-auto">
      <div>
        <label class="text-uppercase fw-bold text-secondary mb-2"
          style="font-size: 10px; letter-spacing: 0.5px;">TAG</label>
        <input type="text" name="tags" class="form-control text-secondary lh-sm mb-2" style="font-size: 12px;"
          placeholder="ex: Software, Web" value="{{ isset($service->tags) && is_array($service->tags) ? implode(', ', $service->tags) : $service->tags ?? '' }}" required>
      </div>
      <div>
        <label class="text-uppercase fw-bold text-secondary mb-2" style="font-size: 10px; letter-spacing: 0.5px;">TÍTULO
          DO SERVIÇO</label>
        <input type="text" name="name" class="form-control text-dark fw-medium"
          value="{{ $service->name ?? 'Informe o Título do serviço' }}" style="font-size: 13px;" required>
      </div>
      <div>
        <label class="text-uppercase fw-bold text-secondary mb-2"
          style="font-size: 10px; letter-spacing: 0.5px;">ÍCONE</label>
        <input type="text" name="icon" class="form-control text-dark fw-medium mb-2"
          value="{{ $service->icon ?? 'bi-code-slash' }}" style="font-size: 13px;" placeholder="ex: bi-code-slash">
        <div class="d-flex gap-2 flex-wrap">
          <button type="button" class="btn btn-primary d-flex align-items-center justify-content-center p-0"
            style="width: 32px; height: 32px;"><i class="bi bi-code-slash"></i></button>
          <button type="button"
            class="btn btn-light border d-flex align-items-center justify-content-center p-0 text-secondary"
            style="width: 32px; height: 32px;"><i class="bi bi-grid-1x2"></i></button>
          <button type="button"
            class="btn btn-light border d-flex align-items-center justify-content-center p-0 text-secondary"
            style="width: 32px; height: 32px;"><i class="bi bi-list-task"></i></button>
          <button type="button"
            class="btn btn-light border d-flex align-items-center justify-content-center p-0 text-secondary"
            style="width: 32px; height: 32px;"><i class="bi bi-lightning-charge"></i></button>
          <button type="button"
            class="btn btn-light border d-flex align-items-center justify-content-center p-0 text-secondary"
            style="width: 32px; height: 32px;"><i class="bi bi-bar-chart"></i></button>
          <button type="button"
            class="btn btn-light border d-flex align-items-center justify-content-center p-0 text-secondary"
            style="width: 32px; height: 32px;"><i class="bi bi-plug"></i></button>
          <button type="button"
            class="btn btn-light border d-flex align-items-center justify-content-center p-0 text-secondary"
            style="width: 32px; height: 32px;"><i class="bi bi-wrench"></i></button>
        </div>
      </div>
      <div>
        <label class="text-uppercase fw-bold text-secondary mb-2"
          style="font-size: 10px; letter-spacing: 0.5px;">STATUS</label>
        <div class="d-flex align-items-center justify-content-between p-3 border rounded">
          <span class="text-success fw-medium d-flex align-items-center gap-1" style="font-size: 12px;">
            <i class="bi bi-circle-fill" style="font-size: 6px;"></i> Publicado
          </span>
          <div class="form-check form-switch m-0 p-0 d-flex align-items-center ms-0 ps-0">
            <input class="form-check-input m-0" type="checkbox" name="status" value="1" role="switch"
              {{ !isset($service) || $service->status == 1 ? 'checked' : '' }}
              style="width: 40px; height: 22px; border:none;">
          </div>
        </div>
      </div>
      <div>
        <label class="text-uppercase fw-bold text-secondary mb-2"
          style="font-size: 10px; letter-spacing: 0.5px;">DESCRIÇÃO COMPLETA</label>
        <textarea name="description" class="form-control text-secondary lh-sm" rows="4" style="font-size: 12px;" required>{{ $service->description ?? '' }}</textarea>
      </div>
      <div>
        <label class="text-uppercase fw-bold text-secondary mb-2"
          style="font-size: 10px; letter-spacing: 0.5px;">FUNCIONALIDADES</label>
        <textarea name="features" class="form-control text-secondary lh-sm mb-2" rows="3" style="font-size: 12px;"
          placeholder="Separe por vírgula" required>{{ isset($service->features) && is_array($service->features) ? implode(', ', $service->features) : $service->features ?? '' }}</textarea>
      </div>
      <div>
        <label class="text-uppercase fw-bold text-secondary mb-2" style="font-size: 10px; letter-spacing: 0.5px;">ORDEM
          DE EXIBIÇÃO</label>
        <div class="d-flex align-items-center gap-3">
          <input type="number" name="sort_order" class="form-control text-center"
            value="{{ $service->sort_order ?? '1' }}" style="width: 60px; font-size: 13px;" required>
          <span class="text-secondary" style="font-size: 11px;">Posição na listagem do site</span>
        </div>
      </div>

    </div>

    <div class="card-footer bg-white border-top p-4 mt-auto d-flex flex-column gap-2">
      <button type="submit"
        class="btn btn-primary w-100 d-flex justify-content-center align-items-center gap-2 fw-medium py-2">
        <i class="bi bi-save" style="font-size: 14px;"></i>
        {{ isset($service) ? 'Salvar Alterações' : 'Cadastrar Serviço' }}
      </button>
      <button type="button" class="btn btn-secondary text-decoration-none w-100"
        style="font-size: 14px;">Cancelar</button>
    </div>
  </form>
</aside>
