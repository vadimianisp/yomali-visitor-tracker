<?php
	$title = "Visitor Statistics";
	ob_start();
?>

    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Visitor Statistics</h1>

    <!-- Loading State -->
    <div id="loading" class="text-center text-gray-500">
        <i class="bi bi-arrow-repeat animate-spin"></i> Loading visitor data...
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 bg-white shadow-md rounded-lg">
            <thead class="bg-gray-200">
            <tr class="text-gray-700">
                <th class="p-3 text-left border border-gray-300">URL</th>
                <th class="p-3 text-left border border-gray-300">Visitor ID</th>
                <th class="p-3 text-left border border-gray-300"><i class="bi bi-globe"></i> IP Address</th>
                <th class="p-3 text-left border border-gray-300"><i class="bi bi-clock"></i> Timestamp</th>
            </tr>
            </thead>
            <tbody id="visit-table" class="text-gray-700">
            <!-- Visits will be loaded dynamically -->
            </tbody>
        </table>
    </div>

    <script>
		document.addEventListener("DOMContentLoaded", function() {
			fetch('/api/visits')
				.then(response => response.json())
				.then(data => {
					document.getElementById('loading').style.display = 'none'; // Hide loading state
					const table = document.getElementById('visit-table');
					
					if (data.data.length === 0) {
						table.innerHTML = `<tr><td colspan="4" class="p-4 text-center text-gray-500">No visits recorded yet.</td></tr>`;
						return;
					}
					
					data.data.forEach(visit => {
						const row = `<tr class="hover:bg-gray-100 transition">
                    <td class="p-3 border border-gray-300">${visit.url}</td>
                    <td class="p-3 border border-gray-300">${visit.visitor_id || '<i class="bi bi-question-circle text-gray-400"></i>'}</td>
                    <td class="p-3 border border-gray-300"><i class="bi bi-globe2"></i> ${visit.ip_address}</td>
                    <td class="p-3 border border-gray-300"><i class="bi bi-clock-history"></i> ${new Date(visit.timestamp * 1000).toLocaleString()}</td>
                </tr>`;
						table.innerHTML += row;
					});
				})
				.catch(error => {
					document.getElementById('loading').innerHTML = `<span class="text-red-500"><i class="bi bi-exclamation-triangle"></i> Error loading visits</span>`;
					console.error('Error loading visits:', error);
				});
		});
    </script>

<?php
	$content = ob_get_clean();
	include __DIR__ . '/layout.php';

