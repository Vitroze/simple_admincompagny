<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Facture {{ $facture->reference }}</title>
    <style>
        @page {
            margin: 28px 32px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: DejaVu Sans, Arial, sans-serif;
            color: #1f2937;
            font-size: 12px;
            line-height: 1.5;
            background: #ffffff;
        }

        .page {
            position: relative;
        }

        .top-band {
            height: 10px;
            background: #0f172a;
            border-radius: 999px;
            margin-bottom: 22px;
        }

        .header {
            display: table;
            width: 100%;
            margin-bottom: 24px;
        }

        .brand,
        .invoice-meta {
            display: table-cell;
            vertical-align: top;
        }

        .brand h1 {
            margin: 0 0 4px 0;
            font-size: 26px;
            color: #0f172a;
            letter-spacing: 0.4px;
        }

        .brand .subtitle {
            margin: 0;
            color: #6b7280;
            font-size: 12px;
        }

        .invoice-meta {
            text-align: right;
        }

        .invoice-label {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            background: #e2e8f0;
            color: #0f172a;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.8px;
        }

        .invoice-number {
            margin: 10px 0 4px 0;
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
        }

        .invoice-date {
            margin: 0;
            color: #6b7280;
        }

        .grid {
            display: table;
            width: 100%;
            margin-bottom: 18px;
            table-layout: fixed;
            border-spacing: 0;
        }

        .card {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 16px 18px;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            background: #f8fafc;
        }

        .card + .card {
            padding-left: 18px;
        }

        .card-title {
            margin: 0 0 10px 0;
            color: #0f172a;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .info-row {
            margin: 0 0 6px 0;
        }

        .info-label {
            display: inline-block;
            min-width: 110px;
            color: #6b7280;
        }

        .info-value {
            font-weight: 600;
            color: #111827;
        }

        .status-pill {
            display: inline-block;
            margin-top: 4px;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-paid {
            background: #dcfce7;
            color: #166534;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .section-title {
            margin: 22px 0 12px 0;
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
        }

        .items-table th,
        .items-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }

        .items-table th {
            background: #0f172a;
            color: #ffffff;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            text-align: left;
        }

        .items-table tbody tr:nth-child(even) td {
            background: #f9fafb;
        }

        .items-table .right {
            text-align: right;
            white-space: nowrap;
        }

        .item-name {
            font-weight: 700;
            color: #111827;
        }

        .item-meta {
            margin-top: 2px;
            color: #6b7280;
            font-size: 11px;
        }

        .summary {
            width: 100%;
            margin-top: 16px;
        }

        .summary-box {
            width: 42%;
            margin-left: auto;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
        }

        .summary-row {
            display: table;
            width: 100%;
            padding: 10px 14px;
            border-bottom: 1px solid #e5e7eb;
            background: #ffffff;
        }

        .summary-row:last-child {
            border-bottom: none;
        }

        .summary-label,
        .summary-value {
            display: table-cell;
            width: 50%;
        }

        .summary-label {
            color: #6b7280;
        }

        .summary-value {
            text-align: right;
            font-weight: 700;
            color: #111827;
        }

        .summary-total {
            background: #0f172a;
            color: #ffffff;
        }

        .summary-total .summary-label,
        .summary-total .summary-value {
            color: #ffffff;
        }

        .footer {
            margin-top: 28px;
            padding-top: 14px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 10px;
        }

        .footer strong {
            color: #111827;
        }
    </style>
</head>
<body>
    @php
        $products = json_decode($facture->products, true);
        if (!is_array($products)) {
            $products = [];
        }

        $statusLabels = [
            'pending' => 'En attente',
            'paid' => 'Payée',
            'cancelled' => 'Annulée',
        ];

        $statusClasses = [
            'pending' => 'status-pending',
            'paid' => 'status-paid',
            'cancelled' => 'status-cancelled',
        ];

        $statusLabel = $statusLabels[$facture->status] ?? ucfirst((string) $facture->status);
        $statusClass = $statusClasses[$facture->status] ?? 'status-pending';
        $issueDate = now()->format('d/m/Y');
        $dueDate = \Carbon\Carbon::parse($facture->due_date)->format('d/m/Y');
        $subtotal = 0;
        $lineItems = [];

        foreach ($products as $product) {
            $name = $product['name'] ?? 'Article';
            $price = (float) ($product['price'] ?? 0);
            $quantity = (int) ($product['quantity'] ?? 1);
            $lineTotal = $price * $quantity;
            $subtotal += $lineTotal;
            $lineItems[] = [
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
                'lineTotal' => $lineTotal,
            ];
        }

        if ($subtotal <= 0) {
            $subtotal = (float) $facture->total_amount;
        }

        $companyName = "Simple AdminCompagny";
    @endphp

    <div class="page">
        <div class="top-band"></div>

        <table class="header" cellpadding="0" cellspacing="0">
            <tr>
                <td class="brand">
                    <h1>{{ $companyName }}</h1>
                    <p class="subtitle">Facture commerciale professionnelle</p>
                </td>
                <td class="invoice-meta">
                    <span class="invoice-label">Facture</span>
                    <div class="invoice-number">{{ $facture->reference }}</div>
                    <p class="invoice-date">Émise le {{ $issueDate }}</p>
                </td>
            </tr>
        </table>

        <table class="grid" cellpadding="0" cellspacing="0">
            <tr>
                <td class="card" style="padding-right: 14px;">
                    <p class="card-title">Émetteur</p>
                    <p class="info-row"><span class="info-value">{{ $companyName }}</span></p>
                    <p class="info-row"><span class="info-label">Document</span><span class="info-value">Facture client</span></p>
                    <p class="info-row"><span class="info-label">Référence</span><span class="info-value">{{ $facture->reference }}</span></p>
                </td>
                <td class="card" style="padding-left: 14px;">
                    <p class="card-title">Client</p>
                    <p class="info-row"><span class="info-value">{{ $facture->client_name }}</span></p>
                    <p class="info-row"><span class="info-label">Date d’échéance</span><span class="info-value">{{ $dueDate }}</span></p>
                    <p class="info-row"><span class="info-label">Statut</span><br><span class="status-pill {{ $statusClass }}">{{ $statusLabel }}</span></p>
                </td>
            </tr>
        </table>

        <div class="section-title">Détail des prestations</div>

        <table class="items-table" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th style="width: 52%;">Produit</th>
                    <th style="width: 12%;" class="right">Qté</th>
                    <th style="width: 18%;" class="right">Prix unitaire</th>
                    <th style="width: 18%;" class="right">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lineItems as $item)
                    <tr>
                        <td>
                            <div class="item-name">{{ $item['name'] }}</div>
                            <div class="item-meta">Prestation facturée</div>
                        </td>
                        <td class="right">{{ $item['quantity'] }}</td>
                        <td class="right">{{ number_format($item['price'], 2, ',', ' ') }} €</td>
                        <td class="right">{{ number_format($item['lineTotal'], 2, ',', ' ') }} €</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #6b7280; padding: 18px;">
                            Aucun article n’a été renseigné pour cette facture.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <table class="summary" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width: 58%;"></td>
                <td>
                    <div class="summary-box">
                        <div class="summary-row">
                            <span class="summary-label">Sous-total</span>
                            <span class="summary-value">{{ number_format($subtotal, 2, ',', ' ') }} €</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Total à payer</span>
                            <span class="summary-value">{{ number_format((float) $facture->total_amount, 2, ',', ' ') }} €</span>
                        </div>
                        <div class="summary-row summary-total">
                            <span class="summary-label">Solde dû</span>
                            <span class="summary-value">{{ number_format((float) $facture->total_amount, 2, ',', ' ') }} €</span>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <div class="footer">
            <strong>{{ $companyName }}</strong> - Merci pour votre confiance. Cette facture a été générée automatiquement le {{ $issueDate }}.
        </div>
    </div>
</body>
</html>