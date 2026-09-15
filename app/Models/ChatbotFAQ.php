<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotFAQ extends Model
{
    protected $table = 'chatbot_faqs';
    protected $fillable = ['topik', 'keywords', 'jawaban'];
}
