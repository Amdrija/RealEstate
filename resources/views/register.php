<div class="uk-margin-auto login-modal uk-margin-top">
    <h1 class="uk-text-center">Registruj se</h1>
    <?php if (!empty($error)): ?>
        <div class="alert-container">
            <div class="alert-message"><?= $error ?></div>
            <div class="alert-button">×</div>
        </div>
    <?php endif; ?>
    <div class="center-content">
        <form method="post">
            <div class="uk-inline uk-margin-top uk-width-1-1">
                <span class="uk-form-icon" uk-icon="icon: user"></span>
                <input class="uk-input uk-width-1-1" type="text" placeholder="Korisničko ime" name="username" required>
            </div>
            <div class="uk-inline uk-margin-top uk-width-1-1">
                <span class="uk-form-icon uk-form-icon" uk-icon="icon: lock"></span>
                <input class="uk-input uk-width-1-1" type="password" placeholder="Lozinka" name="password" required>
            </div>

            <div class="uk-inline uk-margin-top uk-width-1-1">
                <span class="uk-form-icon uk-form-icon" uk-icon="icon: lock"></span>
                <input class="uk-input uk-width-1-1" type="password" placeholder="Potvrdi lozinku" name="confirmedPassword" required>
            </div>


            <div class="uk-inline uk-margin-top uk-width-1-1">
                <input class="uk-input uk-width-1-1" type="text" placeholder="Ime" name="firstname" required>
            </div>
            <div class="uk-inline uk-margin-top uk-width-1-1">
                <input class="uk-input uk-width-1-1" type="text" placeholder="Prezime" name="lastname" required>
            </div>
            <div class="uk-inline uk-margin-top uk-width-1-1">
                <select class="uk-select" required name="cityId">
                    <option value="">Izaberi grad...</option>
                    <?php $cities = [['name' => 'Beograd', 'value' => '1'], ['name' => 'Nis', 'value' => '2']] ?>
                    <?php foreach ($cities as $city) {
                        echo "<option value=\"{$city['value']}\">{$city['name']}</option>";
                    }?>
                </select>
            </div>
            <div class="uk-inline uk-margin-top uk-width-1-1">
                <span class="uk-form-icon uk-form-icon" uk-icon="icon: calendar"></span>
                <input class="uk-input uk-width-1-1" type="date" placeholder="Datum rodjenja" name="birthDate" required>
            </div>
            <div class="uk-inline uk-margin-top uk-width-1-1">
                <span class="uk-form-icon uk-form-icon" uk-icon="icon: phone"></span>
                <input class="uk-input uk-width-1-1" type="tel" placeholder="Telefon" name="phoneNumber" required>
            </div>
            <div class="uk-inline uk-margin-top uk-width-1-1">
                <span class="uk-form-icon uk-form-icon" uk-icon="icon: mail"></span>
                <input class="uk-input uk-width-1-1" type="email" placeholder="me@example.com" name="email" required>
            </div>


            <div class="uk-inline uk-margin-top uk-width-1-1">
                <select class="uk-select" name="agencyId">
                    <option value="">Izaberi grad...</option>
                    <?php $agencies = [['name' => 'Agencija1', 'value' => '1'], ['name' => 'Agencija2', 'value' => '2']] ?>
                    <?php foreach ($agencies as $agency) {
                        echo "<option value=\"{$agency['value']}\">{$agency['name']}</option>";
                    }?>
                </select>
            </div>
            <div class="uk-inline uk-margin-top uk-width-1-1">
                <span class="uk-form-icon" uk-icon="icon: user"></span>
                <input class="uk-input uk-width-1-1" type="text" placeholder="Broj licence" name="licenceNumber" required>
            </div>

            <input type="submit" class="uk-button uk-button-primary uk-margin-top" value="Registruj se">
        </form>
    </div>
</div>