function attachDataTable(selector,orderNo=0,orderDir='desc') {
     const table = $(selector).DataTable({
                order: [[ orderNo, orderDir ]],
                pageLength: 10,
                lengthChange: true,
                searching: true,
                pagingType: 'full_numbers',
                renderer: 'tailwindTheme',
                language: {
                    info: "",
                    infoFiltered: "",
                    paginate: {
                        previous: '',
                        next: '',
                        first: '',
                        last: ''
                    }
                },
                // hide default placement, we’ll re-attach manually
                dom: 't<"dt-hidden-l"l><"dt-hidden-f"f><"dt-hidden-i"i><"dt-hidden-p"p>',

                drawCallback: function() {
                    const api = this.api();
                    const info = api.page.info();
                    const start = info.recordsDisplay ? info.start + 1 : 0;
                    const end = info.end;
                    const total = info.recordsDisplay;

                    $('[data-dt="plots-info"]').html(
                        `Showing <span class="font-medium">${start}</span> to <span class="font-medium">${end}</span> of <span class="font-medium">${total}</span> results`
                    );
                },

                initComplete: function() {
                    const $wrapper = $(this.api().table().container());

                    // --- TOP BAR (Show entries + Search) ---
                    const $topBar = $(`
                    <div class="bg-white rounded-lg shadow mb-4 p-4">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div class="dt-length"></div>
                            <div class="dt-search"></div>
                        </div>
                    </div>
                `);

                    // --- BOTTOM BAR (Info + Pagination) ---
                    const $bottomBar = $(`
                    <div class="bg-white rounded-lg shadow mt-4 p-4">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div class="text-sm text-gray-700" data-dt="plots-info"></div>
                            <div class="flex space-x-2" data-dt="plots-pager"></div>
                        </div>
                    </div>
                `);

                    // Insert bars
                    $wrapper.before($topBar); // TOP
                    $wrapper.after($bottomBar); // BOTTOM

                    // Move DataTables controls into bars
                    $wrapper.find('.dataTables_length').appendTo($topBar.find('.dt-length'));
                    $wrapper.find('.dataTables_filter').appendTo($topBar.find('.dt-search'));
                    $wrapper.find('.dataTables_paginate').appendTo($bottomBar.find('[data-dt="plots-pager"]'));

                    // Tailwind-ify
                    $topBar.find('select').addClass('border rounded px-2 py-1 text-sm');
                    $topBar.find('input[type="search"]').addClass('border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:outline-none');

                    this.api().draw(false);
                }
            });
}
