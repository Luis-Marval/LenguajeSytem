<div class="flex justify-end text-lg gap-1">
  <?php if ($numeroPaginas > 1): ?>
    <?php if ($pagina > 1): ?>
      <a href="<?php echo $reference . "1" ?>" class="btn bg-primary text-white mt-2  font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-">
        inicio
      </a>
      <a href="<?php echo  $reference . $anterior ?>" class="btn bg-primary text-white mt-2  font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-">
        anterior
      </a>
    <?php endif ?>
    <?php foreach ($nums as $num): ?>
      <a href="<?php echo $reference . $num ?>" class="btn bg-primary text-white mt-2  font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-">
        <?php echo $num ?>
      </a>
    <?php endforeach ?>
    <?php if ($pagina < $numeroPaginas): ?>
      <a href="<?php echo  $reference . $siguiente ?>" class="btn bg-primary text-white mt-2  font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-">
        siguiente
      </a>
      <a href="<?php echo  $reference . $numeroPaginas ?>" class="btn bg-primary text-white mt-2  font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-" style='  '>
        fin
      </a>
    <?php endif ?>
  <?php endif ?>
</div>