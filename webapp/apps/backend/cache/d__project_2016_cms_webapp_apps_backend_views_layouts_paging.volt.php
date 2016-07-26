
<div class="row text-center">
    <div class="col-sm-12">
        <?php if ($painginfo['rowcount'] > 0) { ?>
        <ul class="pagination">
            <ul class="pagination">
                <li class="prev"><a class="button" href="<?= $painginfo['currentlink'] ?>&p=<?= ($painginfo['page'] - 1 <= 1 ? 1 : $painginfo['page'] - 1) ?>">Prev</a></li>
                <?php foreach ($painginfo['rangepage'] as $index => $item) { ?>
                    <li class="page-<?= $index + 1 ?> <?= ($item == $painginfo['page'] ? 'active' : '') ?>"><a class="button" href="<?= $painginfo['currentlink'] ?>&p=<?= $item ?>"><?= $item ?></a></li>
                <?php } ?>
                <li class="next"><a class="button" href="<?= $painginfo['currentlink'] ?>&p=<?= ($painginfo['page'] + 1 >= $painginfo['totalpage'] ? $painginfo['totalpage'] : $painginfo['page'] + 1) ?>">Next</a></li>
            </ul>
        </ul>
        <?php } else { ?>
        <p class="text-success m-t-10">Không tìm thấy kết quả nào</p>
        <?php } ?>
    </div>
</div>