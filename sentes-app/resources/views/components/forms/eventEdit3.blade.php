<div class="form-col">
    <div class="form-input">
        <label class="text-shadowed" for="photos_link">Lien vers l'album photo :</label>
        <input type="text" name="photos_link" id="photos_link"  value="{{ $event->photos_link }}">
        @error('photos_link')
        <p>
            {{ $message }}
        </p>
        @enderror
        @if ($event->photos_link)
        <p class="text-green">Album actuel :</p>
        <a href="{{ $event->photos_link }}" class="text-green" target="_blank">{{ $event->photos_link}}</a>
        @endif
    </div>

    <div class="form-input">
        <label class="text-shadowed" for="video_link">Lien vers la vidéo :</label>
        <input type="text" name="video_link" id="video_link"  value="{{ $event->video_link }}">
        @error('video_link')
        <p>
            {{ $message }}
        </p>
        @enderror
        @if ($event->video_link)
        <p class="text-green">Lien actuel :</p>
        <a href="{{ $event->video_link }}" class="text-green" target="_blank">{{ $event->video_link}}</a>
        @endif
    </div>
</div>
<div class="form-col">
    <div class="form-input">
        <label class="text-shadowed" for="retex_form_link">Lien vers le formulaire de débrief :</label>
        <input type="text" name="retex_form_link" id="retex_form_link"  value="{{ $event->retex_form_link }}">
        @error('retex_form_link')
        <p>
            {{ $message }}
        </p>
        @enderror
        @if ($event->retex_form_link)
        <p class="text-green">Lien actuel :</p>
        <a href="{{ $event->retex_form_link }}" class="text-green" target="_blank">{{ $event->retex_form_link}}</a>
        @endif
    </div>

    <div class="form-input">
        <label class="text-shadowed" for="retex_document_path">Document de débrief :</label>
        <input type="file" name="retex_document_path" id="retex_document_path" >
        @error('retex_document_path')
        <p>
            {{ $message }}
        </p>
        @enderror
        @if ($event->retex_document_path)
        <p class="text-green">Document actuel :</p>
        <a href="{{ asset('storage/' . $event->retex_document_path) }}" class="text-green" target="_blank">Voir dans une autre page.</a>
        @endif
    </div>
</div>
