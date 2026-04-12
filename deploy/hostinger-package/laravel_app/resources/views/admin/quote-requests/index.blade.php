@extends('layouts.admin')

@section('title', 'Presupuestos Admin | M&Ouml;BELS Alejandro')
@section('eyebrow', 'Comercial')
@section('page-title', 'Presupuestos recibidos')
@section('page-copy', 'Listado centralizado de consultas enviadas desde las fichas de producto para que el seguimiento comercial quede ordenado.')

@section('content')
    <section class="table-shell">
        <div class="table-head">
            <div>
                <span class="pill">Inbox comercial</span>
                <h2>Solicitudes de presupuesto</h2>
                <p class="table-caption">Cada registro conserva el producto consultado, los datos de contacto y el detalle del proyecto.</p>
            </div>
        </div>

        @if ($quoteRequests->isEmpty())
            <div class="empty-state">
                <span class="pill">Sin consultas</span>
                <h2>Todavia no entraron presupuestos.</h2>
                <p>Cuando un cliente use el formulario desde una ficha, aparecerá en este listado.</p>
            </div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Producto</th>
                            <th>Contacto</th>
                            <th>Detalle</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quoteRequests as $quoteRequest)
                            <tr>
                                <td>
                                    <div class="entity">
                                        <strong>{{ $quoteRequest->customer_name }}</strong>
                                        <p>{{ $quoteRequest->city ?: 'Sin localidad' }}</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="entity">
                                        <strong>{{ $quoteRequest->product?->name ?? 'Producto eliminado' }}</strong>
                                        <p>{{ $quoteRequest->product?->category?->name ?? 'Sin categoria' }}</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="entity">
                                        <strong>{{ $quoteRequest->phone }}</strong>
                                        <p>{{ $quoteRequest->email ?: 'Sin email' }}</p>
                                    </div>
                                </td>
                                <td>{{ $quoteRequest->project_details }}</td>
                                <td>
                                    <div class="entity">
                                        @if ($quoteRequest->status === 'pending')
                                            <span class="status-pill status-danger">Pendiente</span>
                                        @else
                                            <span class="status-pill status-ok">{{ ucfirst($quoteRequest->status) }}</span>
                                        @endif
                                        <p>{{ $quoteRequest->created_at?->format('d/m/Y H:i') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection
