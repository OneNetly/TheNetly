<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">Search Page</h1>
        <form id="searchForm" action="search.php" method="GET" class="mb-4">
            <div class="flex">
                <input type="text" id="searchInput" name="query" class="w-full px-4 py-2 border border-gray-300 rounded-l focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your search query">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-r hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Search</button>
            </div>
        </form>
        <div id="suggestionBox" class="bg-white border border-gray-300 rounded p-4" style="display: none;"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const searchForm = document.getElementById('searchForm');
        const searchInput = document.getElementById('searchInput');
        const suggestionBox = document.getElementById('suggestionBox');

        searchInput.addEventListener('input', function () {
            const query = this.value;
            if (query.length > 2) {
                axios.get('search_suggestions.php', {
                    params: {
                        query: query
                    }
                })
                .then(function (response) {
                    const suggestions = response.data;
                    suggestionBox.innerHTML = '';
                    suggestions.forEach(function (suggestion) {
                        const suggestionItem = document.createElement('div');
                        suggestionItem.className = 'py-2 cursor-pointer hover:bg-gray-100';
                        suggestionItem.textContent = suggestion;
                        suggestionItem.addEventListener('click', function () {
                            searchInput.value = suggestion;
                            suggestionBox.style.display = 'none';
                            searchForm.submit();
                        });
                        suggestionBox.appendChild(suggestionItem);
                    });
                    suggestionBox.style.display = 'block';
                })
                .catch(function (error) {
                    console.error(error);
                });
            } else {
                suggestionBox.style.display = 'none';
            }
        });
    </script>
</body>
</html>