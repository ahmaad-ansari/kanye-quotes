<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanye West Quotes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <div class="container mx-auto mt-10">
        <div class="flex justify-center">
            <div class="w-full md:w-1/2 lg:w-1/3">
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="flex justify-between items-center p-4 border-b">
                        <span class="text-xl font-semibold">Random Kanye West Quote</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-red-500 hover:text-red-700">Logout</button>
                        </form>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-col items-center justify-center min-h-[200px]">
                            <p class="text-2xl italic text-center mb-4" id="quote-text">"{{ $quote }}"</p>
                            
                            <div id="loading" class="hidden text-2xl text-center mb-4">
                                <p>Loading...</p>
                            </div>

                            <button class="bg-blue-500 text-white py-2 px-6 rounded-full hover:bg-blue-600 transition" id="refresh-quote">Get Another Quote</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('refresh-quote').addEventListener('click', function() {
            document.getElementById('loading').classList.remove('hidden');
            document.getElementById('quote-text').classList.add('hidden');
            
            fetch('/api/quotes', {
                headers: {
                    'Authorization': 'Bearer {{ config("auth.api_token") }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('loading').classList.add('hidden');
                document.getElementById('quote-text').classList.remove('hidden');
                document.getElementById('quote-text').innerText = '"' + data.quote + '"';
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('loading').classList.add('hidden');
            });
        });
    </script>

</body>
</html>
