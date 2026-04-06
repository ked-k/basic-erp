@php
    $settings_data = \App\Models\Utility::settingsById($invoice->created_by);
@endphp
<!DOCTYPE html>
<html lang="en" dir="{{ $settings_data['SITE_RTL'] == 'on' ? 'rtl' : '' }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet" />

    <style type="text/css">
        :root {
            --theme-color: {{ $color }};
            --white: #ffffff;
            --black: #000000;
        }

        body {
            font-family: 'Lato', sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 12px;
            color: #000;
        }

        p,
        li,
        ul,
        ol {
            margin: 0;
            padding: 0;
            list-style: none;
            line-height: 1.4;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            color: #000;
        }

        table tr th {
            padding: 6px 8px !important;
            text-align: left;
            border: 1px solid #ccc;
            background: var(--theme-color);
            color:  #0CBA5D;
            font-weight: 600;
        }

        table tr td {
            padding: 6px 8px !important;
            text-align: left;
            border: 1px solid #ccc;
            vertical-align: middle;
        }

        .invoice-preview-main {
            max-width: 700px;
            width: 100%;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0 0 10px #ddd;
            padding: 15px 20px;
        }

        .invoice-logo {
            max-width: 200px;
            width: 100%;
            display: block;
            margin-bottom: 15px;
        }

        .invoice-header table td {
            padding: 6px 8px !important;
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }

        .no-space tr td {
            padding: 0 !important;
            white-space: nowrap;
        }

        .vertical-align-top td {
            vertical-align: top;
        }

        .view-qrcode {
            max-width: 10px;
            height: 10px;
            margin-left: auto;
            margin-top: 1;
        }

        .view-qrcode img {
            width: 20%;
            height: 20%;
        }

        .invoice-body {
            padding: 10px 0 0 0;
        }

        table.add-border tr {
            border-top: 1px solid var(--theme-color);
        }

        tfoot tr:first-of-type {
            border-bottom: 1px solid var(--theme-color);
        }

        .total-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        .total-table tr td {
            padding: 4px 8px;
            border: none;
        }

        .total-table tr:not(:last-child) td {
            border-bottom: 1px solid #ccc;
        }

        .total-table tr strong {
            font-weight: 700;
        }

        .sub-total {
            padding-right: 0;
            padding-left: 0;
        }

        .border-0 {
            border: none !important;
        }

        .invoice-summary td,
        .invoice-summary th {
            font-size: 12px;
            font-weight: 600;
        }

        .total-table td:last-of-type {
            width: 140px;
        }

        .invoice-footer {
            padding: 10px 0 0 0;
            font-size: 11px;
            color: #333;
            border-top: 1px solid #ddd;
            margin-top: 20px;
        }

        /* Item description inside same cell */
        td.item-name {
            vertical-align: top;
            padding: 6px 6px 3px 6px !important;
        }

        td.item-name p.description {
            font-size: 9px;
            font-style: italic;
            color: #555;
            margin: 2px 0 0 0;
            line-height: 1.2;
        }

        /* Remove border from description row if any */
        tr.itm-description {
            border: none !important;
        }

        tr.itm-description td {
            border: none !important;
            padding: 0 6px 6px 6px !important;
        }

        /* RTL fixes */
        html[dir="rtl"] table tr td,
        html[dir="rtl"] table tr th {
            text-align: right;
        }

        html[dir="rtl"] .text-right {
            text-align: left;
        }

        html[dir="rtl"] .view-qrcode {
            margin-left: 0;
            margin-right: auto;
        }

        /* Responsive smaller text on narrow screens */
        @media (max-width: 426px) {
            .invoice-summary td,
            .invoice-summary th {
                font-size: 10px;
                padding: 4px 6px !important;
            }

            .no-space tr td {
                font-size: 10px;
            }

            .invoice-header table td {
                padding: 8px 6px !important;
            }

            .company-detail {
                font-size: 10px;
            }
        }
    </style>

    @if ($settings_data['SITE_RTL'] == 'on')
        <link rel="stylesheet" href="{{ asset('css/bootstrap-rtl.css') }}" />
    @endif
</head>

<body>
    <div class="invoice-preview-main" id="boxes">
        <div class="invoice-header">
            <table class="vertical-align-top" style="width:100%">
                <tbody>
                    <tr>
                        <td style="width: 60%; font-size: 12px;">
                               <img src="{{ (!empty($img) && file_exists(public_path($img))) ? $img : asset('assets/images/logo.png') }}"
                                class="invoice-logo" alt="Logo" />
                            {{-- <h3
                                style="text-transform: uppercase; font-weight: bold; margin-bottom: 6px; color: {{ $color }}; font-size: 24px;">
                                {{ __('INVOICE') }}
                            </h3> --}}
                            <p class="company-detail" style="line-height: 1.1;">
                                @if ($settings['company_name']){{ $settings['company_name'] }}@endif<br />
                                @if ($settings['mail_from_address']){{ $settings['mail_from_address'] }}@endif<br />
                                @if ($settings['company_address']){{ $settings['company_address'] }}@endif
                                @if ($settings['company_city']) <br />{{ $settings['company_city'] }}, @endif
                                @if ($settings['company_state']){{ $settings['company_state'] }}@endif
                                @if ($settings['company_zipcode']) - {{ $settings['company_zipcode'] }}@endif
                                @if ($settings['company_country']) <br />{{ $settings['company_country'] }}@endif
                                @if ($settings['company_telephone']){{ $settings['company_telephone'] }}@endif<br />
                                @if (!empty($settings['registration_number']))
                                    {{ __('Registration Number') }} : {{ $settings['registration_number'] }} @endif<br />
                                @if ($settings['vat_gst_number_switch'] == 'on')
                                    @if (!empty($settings['tax_type']) && !empty($settings['vat_number']))
                                        {{ $settings['tax_type'] . ' ' . __('Number') }} : {{ $settings['vat_number'] }}
                                        <br />
                                    @endif
                                    <strong>{{ __('Tax Number ') }} :</strong>{{ !empty($customer->tax_number) ? $customer->tax_number : '' }}
                                @endif
                            </p>
                        </td>

                        <td style="width: 40%; vertical-align: top;">


                            <table class="no-space" style="width:100%;">
                                <tbody>
                                    <tr>
                                        <td>     <h3
                                style="text-transform: uppercase; font-weight: bold; margin-bottom: 6px; color:#0299D8; font-size: 20px;">
                                {{ __('INVOICE') }}
                            </h3>
                                            {{ __('Number') }}:</td>
                                        <td class="text-right" style="font-weight:600;">
                                            {{ Utility::invoiceNumberFormat($settings, $invoice->invoice_id) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Issue Date') }}:</td>
                                        <td class="text-right">{{ Utility::dateFormat($settings, $invoice->issue_date) }}</td>
                                    </tr>

                                    <tr>
                                        <td><b>{{ __('Due Date:') }}</b></td>
                                        <td class="text-right">{{ Utility::dateFormat($settings, $invoice->due_date) }}</td>
                                    </tr>

                                    @if (!empty($customFields) && count($invoice->customField) > 0)
                                        @foreach ($customFields as $field)
                                            <tr>
                                                <td>{{ $field->name }} :</td>
                                                <td>{{ !empty($invoice->customField) ? $invoice->customField[$field->id] : '-' }}</td>
                                            </tr>
                                        @endforeach
                                    @endif

                                    @if ($settings['invoice_qr_display'] == 'on')
                                        <tr>
                                            <td colspan="2" style="text-align:center; padding-top: 4px;">
                                                <div class="view-qrcode">
                                                    {!! DNS2D::getBarcodeHTML(route('invoice.link.copy', \Crypt::encrypt($invoice->invoice_id)), 'QRCODE', 2, 2) !!}
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="invoice-body">
            <table>
                <tbody>
                    <tr>
                        <td style="width: 100%;">
                            <strong style="margin-bottom: 6px; display: block;">{{ __('Bill To') }}:</strong>
                            @if (!empty($customer->billing_name))
                                <p style="line-height: 1.3;">
                                    {{ $customer->billing_name ?? '' }}<br />
                                    {{ $customer->billing_address ?? '' }}<br />
                                    {{ $customer->billing_city ? $customer->billing_city . ', ' : '' }}<br />
                                    {{ $customer->billing_state ? $customer->billing_state . ', ' : '' }}
                                    {{ $customer->billing_zip ?? '' }}<br />
                                    {{ $customer->billing_country ?? '' }}<br />
                                    {{ $customer->billing_phone ?? '' }}<br />
                                </p>
                            @else
                                -
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-top: 6px;">
                            @php
                                $statusClassMap = [
                                    0 => 'bg-primary',
                                    1 => 'bg-warning',
                                    2 => 'bg-danger',
                                    3 => 'bg-info',
                                    4 => 'bg-primary',
                                ];
                                $statusClass = $statusClassMap[$invoice->status] ?? 'bg-secondary';
                            @endphp
                            <span class="badge {{ $statusClass }}" style="padding: 5px 10px; font-size: 11px; color:#fff;">
                                <strong>{{ __('Invoice Status') }} :</strong>
                                {{ __(\App\Models\Invoice::$statues[$invoice->status] ?? '') }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="invoice-summary" style="margin-top: 15px;">
                <thead>
                <tr style="color: #0CBA5D;">
                <th>{{__('Item')}}</th>
                <th>{{__('Quantity')}}</th>
                <th>{{__('Rate')}}</th>
                <th>{{__('Discount')}}</th>
                <th>{{__('Tax')}} (%)</th>
                <th>{{__('Price')}} <small>{{ __('after tax & discount') }}</small></th>
            </tr>
                </thead>
                <tbody>
                    @if (isset($invoice->itemData) && count($invoice->itemData) > 0)
                        @foreach ($invoice->itemData as $item)
                            @php
                                $unitName = App\Models\ProductServiceUnit::find($item->unit);
                                $itemtax = 0;
                            @endphp
                            <tr>
                                <td class="item-name">
                                    {{ $item->name }}
                                    @if (!empty($item->description))
                                        <p class="description">{{ $item->description }}</p>
                                    @endif
                                </td>
                                <td>{{ $item->quantity }} {{ $unitName ? '(' . $unitName->name . ')' : '' }}</td>
                                <td>{{ Utility::priceFormat($settings, $item->price) }}</td>
                                <td>{{ $item->discount != 0 ? Utility::priceFormat($settings, $item->discount) : '-' }}</td>
                                <td>
                                    @if (!empty($item->itemTax))
                                        @foreach ($item->itemTax as $taxes)
                                            @php
                                                $itemtax += $taxes['tax_price'];
                                            @endphp
                                            <p style="margin:0;">{{ $taxes['name'] }} ({{ $taxes['rate'] }}%) {{ $taxes['price'] }}</p>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ Utility::priceFormat($settings, ($item->price * $item->quantity) - $item->discount + $itemtax) }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td><strong>{{ __('Total') }}</strong></td>
                        <td>{{ $invoice->totalQuantity }}</td>
                        <td>{{ Utility::priceFormat($settings, $invoice->totalRate) }}</td>
                        <td>{{ Utility::priceFormat($settings, $invoice->totalDiscount) }}</td>
                        <td>{{ Utility::priceFormat($settings, $invoice->totalTaxPrice) }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td colspan="2" class="sub-total">
                            <table class="total-table" style="width: 100%;">
                                <tr>
                                    <td>{{ __('Subtotal') }}:</td>
                                    <td>{{ Utility::priceFormat($settings, $invoice->getSubTotal()) }}</td>
                                </tr>
                                @if ($invoice->getTotalDiscount())
                                    <tr>
                                        <td>{{ __('Discount') }}:</td>
                                        <td>{{ Utility::priceFormat($settings, $invoice->getTotalDiscount()) }}</td>
                                    </tr>
                                @endif
                                @if (!empty($invoice->taxesData))
                                    @foreach ($invoice->taxesData as $taxName => $taxPrice)
                                        <tr>
                                            <td>{{ $taxName }} :</td>
                                            <td>{{ Utility::priceFormat($settings, $taxPrice) }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                <tr>
                                    <td><strong>{{ __('Total') }}:</strong></td>
                                    <td><strong>{{ Utility::priceFormat($settings, $invoice->getSubTotal() - $invoice->getTotalDiscount() + $invoice->getTotalTax()) }}</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ __('Paid') }}:</td>
                                    <td>{{ Utility::priceFormat($settings, ($invoice->getTotal() - $invoice->getDue()) - ($invoice->invoiceTotalCreditNote())) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Credit Note') }}:</td>
                                    <td>{{ Utility::priceFormat($settings, $invoice->invoiceTotalCreditNote()) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('Due Amount') }}:</strong></td>
                                    <td><strong>{{ Utility::priceFormat($settings, $invoice->getDue()) }}</strong></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tfoot>
            </table>

            <div class="invoice-footer">
                <b>{{ $settings['footer_title'] }}</b> <br />
                {!! $settings['footer_notes'] !!}
            </div>
        </div>
    </div>
    @if(!isset($preview))
    @include('invoice.script');
@endif
</body>

</html>
