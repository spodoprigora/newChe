<?php
if ($breadcrumbs && is_array($breadcrumbs)) {
    foreach ($breadcrumbs as $itemBreadcrumb) {
        if (isset($itemBreadcrumb[ 'label' ]) && isset($itemBreadcrumb[ 'url' ])) {
            $this->params['breadcrumbs'][] = ['label' => $itemBreadcrumb[ 'label' ], 'url' => $itemBreadcrumb[ 'url' ]];
            continue;
        }

        if (isset($itemBreadcrumb[ 'label' ])) {
            $this->params['breadcrumbs'][] = $itemBreadcrumb[ 'label' ];
            continue;
        }
    }
}
?>