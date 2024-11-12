// property.blade.phpa

function openTab(tabId) {
    // Hide all tab content
    document.getElementById('tab1-content').classList.add('hidden');
    document.getElementById('tab2-content').classList.add('hidden');
    document.getElementById('tab3-content').classList.add('hidden');
    document.getElementById('tab4-content').classList.add('hidden');

    // Show the selected tab content
    document.getElementById(tabId + '-content').classList.remove('hidden');
  }

  // Optionally, you can set the default active tab
  document.getElementById('tab1').click(); // Opens the first tab by default