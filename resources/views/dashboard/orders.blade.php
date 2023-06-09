<x-layouts.dashboard-layout>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <x-dashboard.sidebar />

            <!-- Layout container -->
            <div class="layout-page">
                <x-dashboard.navbar />

                {{-- Content --}}
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <!-- Contextual Classes -->
                        <div class="card">
                            <h5 class="card-header">Order Management</h5>
                            <div class="table-responsive text-nowrap">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Invoce ID</th>
                                            <th>Invoce Date</th>
                                            @if (Auth::user()->role->name === 'super-admin')
                                                <th>Branch</th>
                                            @endif
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Price</th>
                                            <th>Expired At</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @foreach ($orders as $order)
                                            <tr class="table-dark">
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                                @if (Auth::user()->role->name === 'super-admin')
                                                    <td>{{ $order->branch->name }}</td>
                                                @endif
                                                <td>{{ $order->user->name }}</td>
                                                <td>{{ $order->user->email }}</td>
                                                <td>{{ Str::shortened_price($order->total_price) }}</td>
                                                <td>{{ $order->expired_at }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-label-success me-1">{{ $order->status }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--/ Contextual Classes -->
                    </div>
                </div>
                {{-- End Content --}}
            </div>
            <!-- / Layout page -->

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        <!-- / Layout wrapper -->
    </div>
</x-layouts.dashboard-layout>
