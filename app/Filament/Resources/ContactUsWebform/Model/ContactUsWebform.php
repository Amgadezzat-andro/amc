<?php

namespace App\Filament\Resources\ContactUsWebform\Model;

use App\Filament\Resources\DropdownList\Model\DropdownList;
use App\Models\Base\BaseModelNotForAdmin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactUsWebform extends BaseModelNotForAdmin
{
    use HasFactory;

    protected $dateFormat = 'U';

    protected $table = 'contact_us_webform';

    const UPDATED_AT = null; // to avoid error of not have updated_at

    protected $fillable =
        [
            'first_name',
            'last_name',
            'email',
            'phone',
            'company',
            'subject_id',
            'message',
        ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(DropdownList::class, 'subject_id', 'id');
    }

    public static function getSubjectList(): array
    {
        return DropdownList::activeWithCategory(DropdownList::CONTACT_SUBJECT)->get()->mapWithKeys(function ($i) {
            return [$i->id => $i->title];
        })->all();
    }




}
