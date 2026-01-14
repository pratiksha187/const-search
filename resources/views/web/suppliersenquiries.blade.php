@extends('layouts.suppliersapp')

@section('title','Supplier Dashboard | ConstructKaro')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Enquiries Inbox</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body class="bg-slate-100 font-sans text-slate-900">

  <!-- Page Container -->
  <div class="max-w-6xl mx-auto px-4 py-6">

    <!-- Header -->
    <div class="mb-6">
      <h1 class="text-2xl font-semibold">Enquiries Inbox</h1>
      <p class="text-sm text-slate-500">Manage and respond to customer enquiries</p>
    </div>

    <!-- Tabs -->
    <div class="flex gap-6 border-b mb-6 text-sm">
      <button class="pb-3 text-blue-600 border-b-2 border-blue-600 font-medium">
        All (24)
      </button>
      <button class="pb-3 text-slate-500 hover:text-blue-600">
        Active (5)
      </button>
      <button class="pb-3 text-slate-500 hover:text-blue-600">
        Quoted (12)
      </button>
      <button class="pb-3 text-slate-500 hover:text-blue-600">
        Closed (7)
      </button>
    </div>

    <!-- Enquiry Card -->
    <div class="bg-white rounded-xl shadow-sm p-6">

      <!-- Card Header -->
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
        <div>
          <h2 class="text-lg font-semibold">R.K. Infra Pvt Ltd</h2>
          <p class="text-sm text-slate-500">
            Contact: Rajesh Kumar • +91 98765 43210
          </p>
        </div>

        <span class="inline-flex w-fit items-center px-3 py-1 rounded-full text-xs font-medium
                     bg-orange-50 text-orange-600">
          New Enquiry
        </span>
      </div>

      <!-- Details Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4 mb-6">
        <div>
          <p class="text-xs text-slate-400">Project Type</p>
          <p class="text-sm font-medium">Internal Roads</p>
        </div>

        <div>
          <p class="text-xs text-slate-400">Location</p>
          <p class="text-sm font-medium">Khopoli, Maharashtra</p>
        </div>

        <div>
          <p class="text-xs text-slate-400">Material Required</p>
          <p class="text-sm font-medium">80mm Paver Blocks</p>
        </div>

        <div>
          <p class="text-xs text-slate-400">Quantity</p>
          <p class="text-sm font-medium">2,500 sq.m</p>
        </div>

        <div>
          <p class="text-xs text-slate-400">Delivery Required</p>
          <p class="text-sm font-medium">Yes</p>
        </div>

        <div>
          <p class="text-xs text-slate-400">Credit Terms</p>
          <p class="text-sm font-medium">15 Days</p>
        </div>
      </div>

      <!-- Notes -->
      <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mb-6">
        <p class="text-sm text-slate-700">
          <span class="font-medium">Additional Notes:</span><br />
          Required for township development project. Need delivery at site.
          Looking for competitive pricing with quality assurance.
        </p>
      </div>

      <!-- Actions -->
      <div class="flex flex-col md:flex-row gap-3">

        <!-- Send Quote -->
        <button class="flex-1 flex items-center justify-center gap-2
                       bg-gradient-to-r from-blue-600 to-blue-700
                       text-white h-12 rounded-lg font-medium hover:opacity-95">
          📄 Send Quote
        </button>

        <!-- Call -->
        <button class="h-12 px-6 rounded-lg bg-green-600 text-white font-medium
                       hover:bg-green-700">
          📞 Call
        </button>

        <!-- WhatsApp -->
        <button class="h-12 px-6 rounded-lg bg-green-500 text-white font-medium
                       hover:bg-green-600">
          💬 WhatsApp
        </button>
      </div>

    </div>
  </div>

</body>
</html>
    
@endsection