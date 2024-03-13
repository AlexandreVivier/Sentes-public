<h2 class="special-elite-regular">
    Informations suplémentaires :
</h2>

<div class="form-wrapper">
    <div class="form-col">

        <div class="form-input">
            <label for="max_attendees" class="text-shadowed">
                Nombre total de participant·es :
            </label>
            <input type="number" name="max_attendees" id="max_attendees" min=1 value="{{ old('max_attendees') ? old('max_attendees') : 1 }}" >
            <p class="text-small italic text-green">
                Incluant toi même et les autres orgas, minimum 1.
            </p>
            @error('max_attendees')
            <p>
                {{ $message }}
            </p>
            @enderror
        </div>
        <div class="form-input">
            <label for="image_path" class="text-shadowed">
                Choisis une image pour ton GN :
            </label>
            <input type="file" name="image_path" accept="image/png, image/jpeg" id="image_path" value="{{ old('image_path') }}">
            <p class="text-small italic text-green">
                jpeg, jpg ou png.
            </p>
            @error('image_path')
            <p>
                {{ $message }}
            </p>
            @enderror
        </div>
        <div class="form-input">
            <label for="end_date" class="text-shadowed">
                Date de fin du GN :
            </label>
            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" >
            <p class="text-small italic text-green">
                Si le GN dure plus d'un jour.
            </p>
            @error('end_date')
            <p>
                {{ $message }}
            </p>
            @enderror
        </div>
        <div class="form-input">
            <label for="price" class="text-shadowed">
                Participation aux frais :
            </label>
            <input type="number" min=1 name="price" id="price" value="{{ old('price') }}" placeholder="€" >
            @error('price')
            <p>
                {{ $message }}
            </p>
            @enderror
        </div>
    </div>
    <div class="form-col">
        <div class="form-input">
            <label for="tickets_link" class="text-shadowed">
                Le lien vers la billetterie de ton choix :
            </label>
            <input type="text" name="tickets_link" id="tickets_link" value="{{ old('tickets_link') }}" placeholder="https://">
            <p class="text-small italic text-green">
                Tu peux passer par
                <a href="https://www.helloasso.com/associations?_gl=1%2a13kj73m%2a_up%2aMQ..&gclid=CjwKCAiAxaCvBhBaEiwAvsLmWN4m84NmUqL1v_7yvRQ7eDN5mjngYwKnkErezRIrzVDRddT4iorj7hoCgKUQAvD_BwE" target="_blank" class="text-green none semi-bold">
                    HelloAsso
                </a> ou toute autre plateforme de ton choix.
            </p>
            @error('tickets_link')
            <p>
                {{ $message }}
            </p>
            @enderror
        </div>

        <div class="form-input">
            <label for="file_path" class="text-shadowed">
                Tu peux charger ici le courrier d'invitation de ton GN :
            </label>
            <input type="file" name="file_path" id="file_path" value="{{ old('file_path') }}" accept="application/pdf" >
            <p class="text-small italic text-green">
                Format .pdf uniquement.
            </p>
            @error('file_path')
            <p>
                {{ $message }}
            </p>
            @enderror
        </div>

        <div class="form-input">
            <label for="server_link" class="text-shadowed">
                Le lien vers le serveur Discord de ton GN :
            </label>
            <input type="text" name="server_link" id="server_link" value="{{ old('server_link') }}" placeholder="https://discord.gg/">
            <p class="text-normal-small italic text-green">
                Assure-toi que le lien coche les <a href="#" class="text-green italic semi-bold" id="discordHelp" >options "jamais" et "illimité"</a> avant de le poster.
            </p>
            @error('server_link')
            <p>
                {{ $message }}
            </p>
            @enderror
        </div>
    </div>
</div>

<dialog class="bg-light border-green">
    @include('components.modals.discordHelp')
</dialog>

@include('components.scripts.discordHelp')

