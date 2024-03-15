<x-maz-sidebar :href="route('dashboard')" :logo="asset('images/logo/smartfarm.png')">
    <!-- Add Sidebar Menu Items Here -->
    <x-maz-sidebar-item name="Menu List" :link="route('menuList')" icon="bi bi-stack"></x-maz-sidebar-item>

    {{-- Menu untuk admin --}}
    <?php if(Auth::user()->id_role == '1'): ?>
    <x-maz-sidebar-item name="User list" :link="route('userList')" icon="bi bi-person"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Cage list" :link="route('cageList')" icon="bi bi-house"></x-maz-sidebar-item>
    <?php endif; ?>
    {{-- Menu untuk pemilik --}}
    <?php if(Auth::user()->id_role == '2'): ?>
    <x-maz-sidebar-item name="Dashboard" :link="route('dashboard')" icon="bi bi-house"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Cage Monitoring" :link="route('cageMonitoring')" icon="bi bi-display"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Cage Visualization" :link="route('cageVisualization')" icon="bi bi-display"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Outlier" icon="bi bi-stack">
        <x-maz-sidebar-sub-item name="Temperature" :link="route('outlier.temperature')"></x-maz-sidebar-sub-item>
        <x-maz-sidebar-sub-item name="Humidity" :link="route('outlier.humidity')"></x-maz-sidebar-sub-item>
        <x-maz-sidebar-sub-item name="Amonia" :link="route('outlier.amonia')"></x-maz-sidebar-sub-item>
    </x-maz-sidebar-item>
    <x-maz-sidebar-item name="Cage Data" :link="route('cageData')" icon="bi bi-files"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Notification" :link="route('notification')" icon="bi bi-bell"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Harvest Data" :link="route('harvestData')" icon="bi bi-basket3"></x-maz-sidebar-item>
    <?php endif; ?>
    {{-- Menu untuk peternak --}}
    <?php if(Auth::user()->id_role == '3'): ?>
    <x-maz-sidebar-item name="Daily Input" :link="route('dailyInput')" icon="bi bi-file-earmark"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Notification" :link="route('notification')" icon="bi bi-bell"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Harvest Data" :link="route('harvestData')" icon="bi bi-basket3"></x-maz-sidebar-item>
    <?php endif; ?>

</x-maz-sidebar>
