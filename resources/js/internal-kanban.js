const board = document.querySelector('#live-kanban');
if (board) {
    let dragged = null;
    let saving = false;
    const status = document.querySelector('#kanban-status');
    const snapshot = () => Array.from(board.querySelectorAll('[data-list]')).map(list => ({ id: Number(list.dataset.list), cards: Array.from(list.querySelectorAll('[data-card-id]')).map(card => Number(card.dataset.cardId)) }));
    const restore = (columns) => columns.forEach(column => column.cards.forEach(id => board.querySelector(`[data-list="${column.id}"]`).append(board.querySelector(`[data-card-id="${id}"]`))));
    board.addEventListener('dragstart', event => {
        if (saving) { event.preventDefault(); return; }
        dragged = event.target.closest('[data-card-id]');
        if (dragged) { event.dataTransfer.setData('text/plain', dragged.dataset.cardId); event.dataTransfer.effectAllowed = 'move'; }
    });
    board.addEventListener('dragover', event => { if (dragged && event.target.closest('[data-column-id]')) { event.preventDefault(); event.dataTransfer.dropEffect = 'move'; } });
    board.addEventListener('drop', async event => {
        const column = event.target.closest('[data-column-id]');
        if (!dragged || !column || saving) return;
        event.preventDefault();
        const before = snapshot();
        const target = event.target.closest('[data-card-id]');
        if (target && target !== dragged) { const after = event.clientY > target.getBoundingClientRect().top + target.offsetHeight / 2; target.parentNode.insertBefore(dragged, after ? target.nextSibling : target); }
        else if (!target) column.querySelector('[data-list]').append(dragged);
        dragged = null; saving = true; status.textContent = 'Salvando movimentação…';
        try {
            const response = await fetch(board.dataset.url, { method: 'POST', credentials: 'same-origin', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }, body: JSON.stringify({ version: Number(board.dataset.version), columns: snapshot() }) });
            if (!response.ok) { const error = await response.json().catch(() => ({})); throw new Error(response.status === 409 ? 'Outra pessoa alterou o quadro. Recarregue a página antes de continuar.' : error.message || 'Não foi possível salvar. Tente novamente.'); }
            const result = await response.json(); board.dataset.version = result.version;
            status.textContent = 'Movimentação salva.';
            // Refresh versions and all card dialogs from persisted state.
            window.location.reload();
        } catch (error) { restore(before); status.textContent = error.message; status.classList.add('text-danger'); }
        finally { saving = false; }
    });
    board.addEventListener('dragend', () => { dragged = null; });
}
