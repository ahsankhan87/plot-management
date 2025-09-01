<?php if (isset($pager) && $pager->getPageCount() > 1): ?>
    <div class="bg-white rounded-lg shadow mt-6 p-4">
        <div class="flex items-center justify-between">

            <!-- Showing X to Y of Z results -->
            <div>
                <?php
                $start = ($pager->getCurrentPage() - 1) * $pager->getPerPage() + 1;
                $end   = min($start + $pager->getPerPage() - 1, $pager->getTotal());
                ?>
                <p class="text-sm text-gray-700">
                    Showing <span class="font-medium"><?= $start ?></span>
                    to <span class="font-medium"><?= $end ?></span>
                    of <span class="font-medium"><?= $pager->getTotal() ?></span> plots
                </p>
            </div>

            <!-- Pagination Links -->
            <div class="flex space-x-2">
                <!-- Previous Button -->
                <?php if ($pager->hasPreviousPage()): ?>
                    <a href="<?= $pager->getPreviousPage() ?>"
                        class="px-3 py-1 rounded border bg-gray-100 text-gray-600 hover:bg-gray-200">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                <?php endif; ?>

                <!-- Page Numbers -->
                <?php foreach ($pager->links() as $link): ?>
                    <a href="<?= $link['uri'] ?>"
                        class="px-3 py-1 rounded border 
                              <?= $link['active'] ? 'bg-primary text-white' : 'bg-white text-gray-600 hover:bg-gray-100' ?>">
                        <?= $link['title'] ?>
                    </a>
                <?php endforeach; ?>

                <!-- Next Button -->
                <?php if ($pager->hasNextPage()): ?>
                    <a href="<?= $pager->getNextPage() ?>"
                        class="px-3 py-1 rounded border bg-gray-100 text-gray-600 hover:bg-gray-200">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>