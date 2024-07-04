<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    
    class AccountRole extends Model {
        use HasFactory;
        use SoftDeletes;
        
        protected $guarded = [];
        
        public function logs () {
            return $this -> morphMany ( Log::class, 'logable' );
        }
        
        public function role_models () {
            return $this -> hasMany ( AccountRoleModels::class, 'account_role_id' );
        }
    }
