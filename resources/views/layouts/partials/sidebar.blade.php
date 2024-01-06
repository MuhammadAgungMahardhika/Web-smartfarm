<x-maz-sidebar :href="route('dashboard')" :logo="asset('images/logo/smartfarm.png')">



    <!-- Add Sidebar Menu Items Here -->
    <x-maz-sidebar-item name="Menu List" :link="route('menuList')" icon="bi bi-stack"></x-maz-sidebar-item>

    {{-- Menu untuk admin --}}
    <?php if(Auth::user()->id_role == '1'): ?>
    <x-maz-sidebar-item name="User list" :link="route('userList')" icon="bi bi-person"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="House list" :link="route('houseList')" icon="bi bi-house"></x-maz-sidebar-item>
    <?php endif; ?>
    {{-- Menu untuk pemilik --}}
    <?php if(Auth::user()->id_role == '2'): ?>
    <x-maz-sidebar-item name="Dashboard" :link="route('dashboard')" icon="bi bi-house"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="House Monitoring" :link="route('houseMonitoring')" icon="bi bi-display"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Outlier Data" :link="route('outlierData')" icon="bi bi-display"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="House Data" :link="route('houseData')" icon="bi bi-files"></x-maz-sidebar-item>
    {{-- <x-maz-sidebar-item name="Forecast" :link="route('forecast')" icon="bi bi-cloud-hail"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Klasifikasi Monitoring" :link="route('klasifikasiMonitoring')" icon="bi bi-collection"></x-maz-sidebar-item> --}}
    <x-maz-sidebar-item name="Notification" :link="route('notification')" icon="bi bi-bell"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Harvest Data" :link="route('harvestData')" icon="bi bi-basket3"></x-maz-sidebar-item>
    <?php endif; ?>
    {{-- Menu untuk peternak --}}
    <?php if(Auth::user()->id_role == '3'): ?>
    {{-- <x-maz-sidebar-item name="Klasifikasi Monitoring" :link="route('klasifikasiMonitoring')" icon="bi bi-collection"></x-maz-sidebar-item> --}}
    <x-maz-sidebar-item name="Daily Input" :link="route('dailyInput')" icon="bi bi-file-earmark"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Notification" :link="route('notification')" icon="bi bi-bell"></x-maz-sidebar-item>
    <?php endif; ?>
    {{-- <x-maz-sidebar-item name="Component" icon="bi bi-stack">
        <x-maz-sidebar-sub-item name="Accordion" :link="route('components.accordion')"></x-maz-sidebar-sub-item>
        <x-maz-sidebar-sub-item name="Alert" :link="route('components.alert')"></x-maz-sidebar-sub-item>
    </x-maz-sidebar-item> --}}

</x-maz-sidebar>
