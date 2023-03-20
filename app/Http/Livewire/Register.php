<?php
 
namespace App\Http\Livewire;
 
use App\Models\User;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\FileUpload;
use Livewire\Component;
use Illuminate\Support\HtmlString;
use Illuminate\Contracts\View\View;
use Filament\Facades\Filament;
 
 
class Register extends Component implements HasForms
{
    use InteractsWithForms;
 
    public User $user;
 
    public $name = '';
    public $email = '';
    public $password = '';
    public $passwordConfirmation  = '';

 
    public function mount(): void
    {
        $this->form->fill();
    }
 
    protected function getFormSchema(): array
    {
        return [
                    TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(50),
                    TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->required()
                    ->maxLength(50)
                    ->unique(User::class),
                    TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->maxLength(50)
                    ->minLength(8)
                    ->same('passwordConfirmation')
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                    TextInput::make('passwordConfirmation')
                    ->label('Confirm Password')
                    ->password()
                    ->required()
                    ->maxLength(50)
                    ->minLength(8)
                    ->dehydrated(false),
                   
        ];
        // submitAction(new HtmlString(html: '<button type="submit">Register</button>'));
            
    }
 
    public function register()
    {
        $user = User::create($this->form->getState());
        Filament::auth()->login(user: $user, remember:true);
        return redirect()->intended(Filament::getUrl('filament.pages.dashboard'));
    }
 
    public function render(): View
    {
        return view('livewire.register');
    }
}
