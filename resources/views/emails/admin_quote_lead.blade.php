<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Quote Lead #{{ $inquiry->id }}</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #09090b;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      color: #f4f4f5;
      -webkit-font-smoothing: antialiased;
    }
    .wrapper {
      width: 100%;
      background-color: #09090b;
      padding: 30px 15px;
      box-sizing: border-box;
    }
    .container {
      max-width: 600px;
      margin: 0 auto;
      background-color: #121215;
      border: 1px solid #27272a;
      border-radius: 18px;
      overflow: hidden;
      box-shadow: 0 20px 40px rgba(0,0,0,0.6);
    }
    .header {
      background: linear-gradient(135deg, #18181b 0%, #09090b 100%);
      padding: 28px 24px;
      text-align: center;
      border-bottom: 2px solid #dc2626;
    }
    .badge {
      display: inline-block;
      padding: 4px 12px;
      border-radius: 20px;
      background-color: rgba(220, 38, 38, 0.2);
      border: 1px solid rgba(220, 38, 38, 0.4);
      color: #f87171;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      margin-bottom: 12px;
    }
    .title {
      margin: 0;
      font-size: 22px;
      font-weight: 800;
      color: #ffffff;
      letter-spacing: 0.5px;
      text-transform: uppercase;
    }
    .subtitle {
      margin: 6px 0 0 0;
      font-size: 12px;
      color: #a1a1aa;
    }
    .body-content {
      padding: 28px 24px;
    }
    .info-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      margin-bottom: 24px;
      background-color: #18181b;
      border: 1px solid #27272a;
      border-radius: 12px;
      overflow: hidden;
    }
    .info-table td {
      padding: 14px 16px;
      border-bottom: 1px solid #27272a;
      font-size: 13px;
    }
    .info-table tr:last-child td {
      border-bottom: none;
    }
    .label {
      color: #a1a1aa;
      font-weight: 600;
      width: 38%;
      text-transform: uppercase;
      font-size: 11px;
      letter-spacing: 0.8px;
    }
    .value {
      color: #ffffff;
      font-weight: 700;
    }
    .highlight-red {
      color: #f87171;
    }
    .highlight-emerald {
      color: #34d399;
    }
    .message-box {
      background-color: #18181b;
      border-left: 3px solid #dc2626;
      padding: 14px 16px;
      border-radius: 6px;
      margin-bottom: 24px;
      font-size: 13px;
      color: #d4d4d8;
      line-height: 1.5;
    }
    .cta-container {
      margin: 24px 0 10px 0;
      text-align: center;
    }
    .btn {
      display: inline-block;
      padding: 12px 22px;
      margin: 4px 6px;
      border-radius: 10px;
      font-size: 12px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      text-decoration: none;
      box-sizing: border-box;
    }
    .btn-whatsapp {
      background-color: #25D366;
      color: #000000 !important;
    }
    .btn-call {
      background-color: #dc2626;
      color: #ffffff !important;
    }
    .btn-email {
      background-color: #27272a;
      border: 1px solid #3f3f46;
      color: #ffffff !important;
    }
    .footer {
      padding: 20px 24px;
      background-color: #09090b;
      text-align: center;
      border-top: 1px solid #27272a;
      font-size: 11px;
      color: #71717a;
    }
    .footer a {
      color: #dc2626;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="container">
      <!-- Header -->
      <div class="header">
        <div class="badge">🏎️ Instant Quote Request</div>
        <h1 class="title">Veneno Lead Alert</h1>
        <p class="subtitle">A new customer inquiry has been submitted via <strong>veneno.ae</strong></p>
      </div>

      <!-- Content -->
      <div class="body-content">
        <table class="info-table">
          <tr>
            <td class="label">Inquiry ID</td>
            <td class="value highlight-red">#{{ $inquiry->id }}</td>
          </tr>
          <tr>
            <td class="label">Customer Name</td>
            <td class="value">{{ $lead['name'] ?? 'Not Specified' }}</td>
          </tr>
          <tr>
            <td class="label">Mobile / WhatsApp</td>
            <td class="value highlight-emerald">{{ $lead['phone'] ?? 'Not Specified' }}</td>
          </tr>
          <tr>
            <td class="label">Email Address</td>
            <td class="value">{{ $lead['email'] ?? 'Not Provided' }}</td>
          </tr>
          <tr>
            <td class="label">Service Requested</td>
            <td class="value highlight-red">{{ $lead['service'] ?? 'General Inquiry' }}</td>
          </tr>
          <tr>
            <td class="label">Preferred Branch</td>
            <td class="value">{{ $lead['branch'] ?? 'Musaffah Main Facility' }}</td>
          </tr>
          <tr>
            <td class="label">Submission Time</td>
            <td class="value" style="font-size: 12px; color: #a1a1aa;">{{ now()->timezone('Asia/Dubai')->format('d M Y — h:i A (GST)') }}</td>
          </tr>
        </table>

        @if(!empty($lead['message']) && $lead['message'] !== 'Direct Instant Quote Lead via veneno.ae')
        <div style="font-size: 11px; text-transform: uppercase; color: #a1a1aa; font-weight: 700; margin-bottom: 6px; letter-spacing: 0.8px;">Customer Note:</div>
        <div class="message-box">
          "{{ $lead['message'] }}"
        </div>
        @endif

        <!-- Quick 1-Click Response Actions -->
        <div class="cta-container">
          @php
            $cleanPhone = preg_replace('/[^0-9]/', '', $lead['phone'] ?? '');
            $waText = urlencode("Hello " . ($lead['name'] ?? '') . ", thank you for contacting Veneno Auto Care Center regarding your quote request for " . ($lead['service'] ?? 'our services') . ". How can we assist you today?");
          @endphp

          @if($cleanPhone)
          <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waText }}" class="btn btn-whatsapp" target="_blank">
            💬 WhatsApp Customer
          </a>
          <a href="tel:{{ $lead['phone'] }}" class="btn btn-call">
            📞 Call Customer
          </a>
          @endif

          @if(!empty($lead['email']) && filter_var($lead['email'], FILTER_VALIDATE_EMAIL))
          <a href="mailto:{{ $lead['email'] }}?subject=Veneno%20Auto%20Care%20%E2%80%94%20Quote%20Inquiry%20%23{{ $inquiry->id }}" class="btn btn-email">
            ✉️ Reply via Email
          </a>
          @endif
        </div>
      </div>

      <!-- Footer -->
      <div class="footer">
        <p style="margin: 0 0 6px 0;"><strong>Veneno Auto Care Center</strong> — The Ultimate Art of Care</p>
        <p style="margin: 0;">Abu Dhabi, UAE • Musaffah & Al Qana Waterfront • <a href="https://veneno.ae">veneno.ae</a></p>
      </div>
    </div>
  </div>
</body>
</html>
