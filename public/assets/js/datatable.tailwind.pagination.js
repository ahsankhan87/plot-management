(function($){
  // DataTables custom pagination renderer: "tailwindTheme"
  $.fn.dataTable.ext.renderer.pageButton.tailwindTheme = function (settings, host, idx, buttons, page, pages) {
    const api = new $.fn.dataTable.Api(settings);
    const $host = $(host);
    $host.empty(); // clear container

    // Create fragment container for our buttons
    const $wrap = $('<div class="flex space-x-2"/>').appendTo($host);

    // helpers
    const makeBtn = (labelHtml, isActive, isDisabled, onClick) => {
      const base = 'px-3 py-1 rounded border';
      const active = ' bg-primary text-white';
      const normal = ' bg-white text-gray-600 hover:bg-gray-100';
      const disabled = ' bg-gray-100 text-gray-400 pointer-events-none';
      const cls = base + (isDisabled ? disabled : (isActive ? active : normal));

      const $a = $('<a href="#" aria-label="page" />')
        .addClass(cls)
        .html(labelHtml)
        .on('click', function(e){
          e.preventDefault();
          if (!isDisabled && onClick) onClick();
        });

      return $a;
    };

    // compute visible number range (max 5 numbers shown)
    const maxNumbers = 5;
    const cur = page;          // 0-based
    const last = pages - 1;    // 0-based
    let start = Math.max(0, cur - Math.floor(maxNumbers/2));
    let end   = start + maxNumbers - 1;
    if (end > last) { end = last; start = Math.max(0, end - (maxNumbers - 1)); }

    // Prev
    $wrap.append(
      makeBtn('<i class="fas fa-chevron-left"></i>', false, cur === 0, () => api.page(cur - 1).draw('page'))
    );

    // First + ellipsis
    if (start > 0) {
      $wrap.append(makeBtn('1', cur === 0, false, () => api.page(0).draw('page')));
      if (start > 1) $wrap.append(makeBtn('<i class="fas fa-ellipsis-h"></i>', false, true));
    }

    // Page numbers
    for (let i = start; i <= end; i++) {
      const title = (i + 1).toString();
      $wrap.append(
        makeBtn(title, i === cur, false, () => api.page(i).draw('page'))
      );
    }

    // Ellipsis + Last
    if (end < last) {
      if (end < last - 1) $wrap.append(makeBtn('<i class="fas fa-ellipsis-h"></i>', false, true));
      $wrap.append(makeBtn((last + 1).toString(), cur === last, false, () => api.page(last).draw('page')));
    }

    // Next
    $wrap.append(
      makeBtn('<i class="fas fa-chevron-right"></i>', false, cur === last, () => api.page(cur + 1).draw('page'))
    );
  };
})(jQuery);
