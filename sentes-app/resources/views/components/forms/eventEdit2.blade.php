<div class="form-col">

    <div class="form-input">
        <label class="text-shadowed" for="price">Prix :</label>
        <input type="number" name="price" id="price"  value="{{ $event->price }}" >
    </div>

    <div class="form-input">
        <label class="text-shadowed" for="max_attendees">Nombre de joueuses :</label>
        <input type="number" name="max_attendees" id="max_attendees"  value="{{ $event->max_attendees }}">
        @error('max_attendees')
        <p>
            {{ $message }}
        </p>
        @enderror
    </div>

    <div class="form-input">
        <label class="text-shadowed" for="file_path">Courrier d'invitation :</label>
        <input type="file" name="file_path" id="file_path" >
        @error('file_path')
        <p>
            {{ $message }}
        </p>
        @enderror
        @if ($event->file_path)
        <p class="text-green">Fichier actuel :</p>
        <a href="{{ asset('storage/' . $event->file_path) }}" class="text-green" target="_blank">Voir dans une autre page.</a>
        @endif
    </div>

    <div class="form-input">
        <label class="text-shadowed" for="tickets_link">Lien de la billetterie :</label>
        <input type="text" name="tickets_link" id="tickets_link"  value="{{ $event->tickets_link }}">
        @error('tickets_link')
        <p>
            {{ $message }}
        </p>
        @enderror
        @if ($event->tickets_link)
        <p class="text-green">Lien actuel :</p>
        <a href="{{ $event->tickets_link }}" class="text-green" target="_blank">{{ $event->tickets_link}}</a>
        @endif
    </div>

    <div class="form-input">
        <label class="text-shadowed" for="server_link">Lien du serveur Discord :</label>
        <input type="text" name="server_link" id="server_link"  value="{{ $event->server_link }}">
        @error('server_link')
        <p>
            {{ $message }}
        </p>
        @enderror
        @if ($event->server_link)
        <p class="text-green">Lien actuel :</p>
        <a href="{{ $event->server_link }}" class="text-green" target="_blank">{{ $event->server_link}}</a>
        @endif
    </div>


</div>
<div class="form-col">

    <div class="form-input">
        <label class="text-shadowed" for="image_path">Changer l'image :</label>
        <input type="file" name="image_path" id="image_path" accept="image/png, image/jpeg" >
        @error('image_path')
        <p>
            {{ $message }}
        </p>
        @enderror
        <p class="text-green">Image actuelle :</p>
        <div class="miniature-edit">
            @if($event->image_path === 'images/static/blank-event.png')
                <img src="{{ asset('images/static/blank-event.png') }}" alt="{{ $event->title }}" class="border-green-lg"/>
            @else
                <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}" class="border-green-lg"/>
            @endif
        </div>
    </div>
</div>
