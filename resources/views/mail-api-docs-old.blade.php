<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail API - Documentation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4f46e5',
                        secondary: '#7c3aed',
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">
    <!-- Navigation -->
        <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-indigo-600">Mail API</h1>
                        <p class="text-sm text-gray-500">by UZASHOP Sarlu</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="https://uzashop.co" target="_blank" class="text-indigo-600 hover:text-indigo-800 font-medium">
                        uzashop.co
                    </a>
                    <span class="text-gray-500">v1.0</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
        <!-- Hero Section -->
    <div class="bg-gradient-to-r from-primary to-secondary text-white">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold sm:text-5xl">
                    Mail API - Documentation
                </h1>
                <p class="mt-4 text-xl">
                    API REST professionnel pour l'envoi d'emails avec Laravel. 
                    Solution robuste et sécurisée développée par <strong>UZASHOP Sarlu</strong>.
                </p>
                <div class="mt-6">
                    <a href="https://uzashop.co" target="_blank" class="inline-flex items-center px-6 py-3 border border-white text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-gray-50 transition duration-150">
                        Visiter uzashop.co
                        <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        <!-- Description Section -->
        <section id="description" class="mb-12">
            <div class="bg-white rounded-xl shadow-md p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">
                    <i class="fas fa-info-circle text-primary mr-3"></i>
                    Description du Service
                </h2>
                <p class="text-lg text-gray-700 leading-relaxed mb-4">
                    Cette API REST permet d'envoyer des emails de manière simple et efficace. 
                    Elle supporte l'envoi d'emails avec des destinataires multiples (CC, BCC), 
                    des pièces jointes et du contenu HTML.
                </p>
                <div class="grid md:grid-cols-3 gap-6 mt-8">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-lg">
                        <i class="fas fa-paper-plane text-blue-500 text-2xl mb-4"></i>
                        <h3 class="font-semibold text-gray-900 mb-2">Envoi Rapide</h3>
                        <p class="text-gray-600 text-sm">Envoyez vos emails en quelques secondes via une simple requête POST</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-6 rounded-lg">
                        <i class="fas fa-shield-alt text-green-500 text-2xl mb-4"></i>
                        <h3 class="font-semibold text-gray-900 mb-2">Sécurisé</h3>
                        <p class="text-gray-600 text-sm">Validation stricte des données et gestion d'erreurs complète</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-violet-50 p-6 rounded-lg">
                        <i class="fas fa-cogs text-purple-500 text-2xl mb-4"></i>
                        <h3 class="font-semibold text-gray-900 mb-2">Flexible</h3>
                        <p class="text-gray-600 text-sm">Support des CC, BCC, pièces jointes et contenu HTML</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- API Documentation -->
        <section id="documentation" class="mb-12">
            <div class="bg-white rounded-xl shadow-md p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">
                    <i class="fas fa-book text-primary mr-3"></i>
                    Documentation API
                </h2>
                
                <!-- Endpoints Table -->
                <div class="overflow-x-auto mb-8">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Endpoint</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Méthode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Authentification</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <code class="bg-gray-100 px-2 py-1 rounded text-sm">/api/send-email</code>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">POST</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">Envoie un email avec les paramètres fournis</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-500">Aucune</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Parameters -->
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">Paramètres de la requête</h3>
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <div class="space-y-4">
                        <div class="border-l-4 border-red-400 pl-4">
                            <code class="text-sm font-mono">to</code> <span class="text-red-500 text-sm">(obligatoire)</span>
                            <p class="text-gray-600 text-sm mt-1">Adresse email du destinataire principal</p>
                        </div>
                        <div class="border-l-4 border-red-400 pl-4">
                            <code class="text-sm font-mono">subject</code> <span class="text-red-500 text-sm">(obligatoire)</span>
                            <p class="text-gray-600 text-sm mt-1">Objet de l'email (max 255 caractères)</p>
                        </div>
                        <div class="border-l-4 border-red-400 pl-4">
                            <code class="text-sm font-mono">message</code> <span class="text-red-500 text-sm">(obligatoire)</span>
                            <p class="text-gray-600 text-sm mt-1">Contenu de l'email (HTML autorisé)</p>
                        </div>
                        <div class="border-l-4 border-blue-400 pl-4">
                            <code class="text-sm font-mono">cc</code> <span class="text-blue-500 text-sm">(optionnel)</span>
                            <p class="text-gray-600 text-sm mt-1">Tableau d'adresses email en copie</p>
                        </div>
                        <div class="border-l-4 border-blue-400 pl-4">
                            <code class="text-sm font-mono">bcc</code> <span class="text-blue-500 text-sm">(optionnel)</span>
                            <p class="text-gray-600 text-sm mt-1">Tableau d'adresses email en copie cachée</p>
                        </div>
                        <div class="border-l-4 border-blue-400 pl-4">
                            <code class="text-sm font-mono">attachments</code> <span class="text-blue-500 text-sm">(optionnel)</span>
                            <p class="text-gray-600 text-sm mt-1">Tableau de fichiers (max 10MB chacun)</p>
                        </div>
                    </div>
                </div>

                <!-- cURL Example -->
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">Exemple avec cURL</h3>
                <div class="bg-gray-900 rounded-lg p-6 mb-6">
                    <pre class="text-green-400 text-sm overflow-x-auto"><code>curl -X POST {{ url('api/send-email') }} \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "to": "destinataire@example.com",
    "subject": "Test Email via API",
    "message": "&lt;h1&gt;Bonjour !&lt;/h1&gt;&lt;p&gt;Ceci est un email de test.&lt;/p&gt;",
    "cc": ["copie@example.com"],
    "bcc": ["copie.cachee@example.com"]
  }'</code></pre>
                </div>

                <!-- Response Examples -->
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">Exemples de réponses</h3>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Success Response -->
                    <div>
                        <h4 class="font-semibold text-green-700 mb-3">
                            <i class="fas fa-check-circle mr-2"></i>
                            Succès (200)
                        </h4>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <pre class="text-green-800 text-sm"><code>{
  "status": "success",
  "message": "Email sent successfully"
}</code></pre>
                        </div>
                    </div>

                    <!-- Error Response -->
                    <div>
                        <h4 class="font-semibold text-red-700 mb-3">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Erreur (500)
                        </h4>
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <pre class="text-red-800 text-sm"><code>{
  "status": "error",
  "message": "Failed to send email"
}</code></pre>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- À propos section -->
        <section id="about" class="mb-12">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl shadow-md p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">
                        <i class="fas fa-info-circle text-primary mr-3"></i>
                        À propos de cette API
                    </h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">
                            <i class="fas fa-building text-indigo-600 mr-2"></i>
                            Développé par UZASHOP Sarlu
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Cette API Mail est développée et maintenue par <strong>UZASHOP Sarlu</strong>, 
                            une société spécialisée dans le développement de solutions web modernes et performantes.
                        </p>
                        <a href="https://uzashop.co" target="_blank" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                            <i class="fas fa-external-link-alt mr-2"></i>
                            Découvrir nos services sur uzashop.co
                        </a>
                    </div>
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">
                            <i class="fas fa-cog text-indigo-600 mr-2"></i>
                            Technologie & Sécurité
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Construite avec Laravel, cette API offre robustesse, sécurité et facilité d'intégration. 
                            Elle respecte les standards REST et inclut une validation complète des données.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm rounded-full">Laravel</span>
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm rounded-full">REST API</span>
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm rounded-full">PHP 8+</span>
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm rounded-full">Sécurisé</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Test API Section -->
        <section id="test-api" class="mb-12">
            <div class="bg-white rounded-xl shadow-md p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">
                    <i class="fas fa-flask text-primary mr-3"></i>
                    Tester l'API
                </h2>
                
                <form id="emailForm" class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="to" class="block text-sm font-medium text-gray-700 mb-2">
                                Destinataire <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="to" name="to" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                   placeholder="destinataire@example.com">
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                Sujet <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="subject" name="subject" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                   placeholder="Sujet de votre email">
                        </div>
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            Message <span class="text-red-500">*</span>
                        </label>
                        <textarea id="message" name="message" rows="6" required 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                  placeholder="Votre message (HTML autorisé)"></textarea>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="cc" class="block text-sm font-medium text-gray-700 mb-2">
                                CC (optionnel)
                            </label>
                            <input type="text" id="cc" name="cc" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                   placeholder="email1@example.com, email2@example.com">
                        </div>
                        
                        <div>
                            <label for="bcc" class="block text-sm font-medium text-gray-700 mb-2">
                                BCC (optionnel)
                            </label>
                            <input type="text" id="bcc" name="bcc" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                   placeholder="email1@example.com, email2@example.com">
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <button type="submit" 
                                class="bg-gradient-to-r from-primary to-secondary text-white px-8 py-3 rounded-lg font-semibold hover:from-indigo-700 hover:to-purple-700 transition transform hover:scale-105 shadow-lg">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Envoyer l'Email
                        </button>
                    </div>
                </form>

                <!-- Response Display -->
                <div id="response" class="hidden mt-8"></div>
            </div>
        </section>
    </div>

    <!-- Footer -->
        <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-300">
                        © {{ date('Y') }} <strong>UZASHOP Sarlu</strong>. Tous droits réservés.
                    </p>
                    <p class="text-gray-400 text-sm mt-1">
                        Mail API - Solution professionnelle d'envoi d'emails
                    </p>
                </div>
                <div class="flex flex-col items-end">
                    <a href="https://uzashop.co" target="_blank" class="text-indigo-400 hover:text-indigo-300 font-medium">
                        uzashop.co
                    </a>
                    <p class="text-gray-400 text-sm mt-1">
                        Powered by Laravel & TailwindCSS
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('emailForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const responseDiv = document.getElementById('response');
            const submitBtn = e.target.querySelector('button[type="submit"]');
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Envoi en cours...';
            
            // Gather form data
            const formData = new FormData();
            formData.append('to', document.getElementById('to').value);
            formData.append('subject', document.getElementById('subject').value);
            formData.append('message', document.getElementById('message').value);
            
            // Handle CC
            const ccValue = document.getElementById('cc').value;
            if (ccValue.trim()) {
                const ccEmails = ccValue.split(',').map(email => email.trim()).filter(email => email);
                ccEmails.forEach(email => formData.append('cc[]', email));
            }
            
            // Handle BCC
            const bccValue = document.getElementById('bcc').value;
            if (bccValue.trim()) {
                const bccEmails = bccValue.split(',').map(email => email.trim()).filter(email => email);
                bccEmails.forEach(email => formData.append('bcc[]', email));
            }

            try {
                const response = await fetch('{{ url("api/send-email") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const result = await response.json();
                
                // Display response
                responseDiv.className = 'mt-8 p-4 rounded-lg border';
                
                if (response.ok && result.status === 'success') {
                    responseDiv.className += ' bg-green-50 border-green-200';
                    responseDiv.innerHTML = `
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-green-800">Succès !</h4>
                                <p class="text-green-700">${result.message}</p>
                            </div>
                        </div>
                    `;
                } else {
                    responseDiv.className += ' bg-red-50 border-red-200';
                    responseDiv.innerHTML = `
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-triangle text-red-500 text-xl mr-3 mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-red-800">Erreur</h4>
                                <p class="text-red-700">${result.message}</p>
                                ${result.errors ? `<div class="mt-2 text-sm text-red-600"><pre>${JSON.stringify(result.errors, null, 2)}</pre></div>` : ''}
                            </div>
                        </div>
                    `;
                }
                
            } catch (error) {
                responseDiv.className = 'mt-8 p-4 rounded-lg border bg-red-50 border-red-200';
                responseDiv.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 text-xl mr-3"></i>
                        <div>
                            <h4 class="font-semibold text-red-800">Erreur de connexion</h4>
                            <p class="text-red-700">Impossible de contacter l'API: ${error.message}</p>
                        </div>
                    </div>
                `;
            }
            
            // Reset button
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Envoyer l\'Email';
            
            // Show response
            responseDiv.classList.remove('hidden');
            responseDiv.scrollIntoView({ behavior: 'smooth' });
        });
    </script>
</body>
</html>
