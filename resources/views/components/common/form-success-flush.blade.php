@props(['message'])

@if (filled($message))
    <style>
        .form-flush-success {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 24px;
            padding: 16px 18px;
            border: 1px solid #b7f0d1;
            border-radius: 14px;
            background: linear-gradient(135deg, #f0fff7 0%, #e7fff2 50%, #ddfbea 100%);
            box-shadow: 0 12px 28px -20px rgba(16, 185, 129, 0.85);
            animation: formFlushIn 260ms ease-out;
        }

        .form-flush-success__icon {
            flex-shrink: 0;
            width: 34px;
            height: 34px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            background: linear-gradient(135deg, #059669 0%, #16a34a 100%);
            box-shadow: 0 8px 14px -10px rgba(5, 150, 105, 0.8);
        }

        .form-flush-success__content {
            flex: 1;
            min-width: 0;
        }

        .form-flush-success__title {
            margin: 0;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.02em;
            color: #065f46;
            text-transform: uppercase;
        }

        .form-flush-success__message {
            margin: 3px 0 0;
            font-size: 15px;
            line-height: 1.5;
            font-weight: 500;
            color: #064e3b;
        }

        .form-flush-success__close {
            flex-shrink: 0;
            width: 28px;
            height: 28px;
            border: 0;
            border-radius: 999px;
            color: #047857;
            background: rgba(16, 185, 129, 0.1);
            cursor: pointer;
            transition: background-color 180ms ease, color 180ms ease, transform 180ms ease;
        }

        .form-flush-success__close:hover {
            background: rgba(16, 185, 129, 0.18);
            color: #065f46;
            transform: scale(1.04);
        }

        @keyframes formFlushIn {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .form-flush-success {
                padding: 14px;
                border-radius: 12px;
            }

            .form-flush-success__message {
                font-size: 14px;
            }
        }
    </style>

    <div class="form-flush-success" role="status" aria-live="polite">
        <span class="form-flush-success__icon" aria-hidden="true">
            <i class="fas fa-check"></i>
        </span>
        <div class="form-flush-success__content">
            <p class="form-flush-success__title">Success</p>
            <p class="form-flush-success__message">{{ $message }}</p>
        </div>
        <button type="button" class="form-flush-success__close" onclick="this.closest('.form-flush-success').remove()" aria-label="Dismiss success message">
            <i class="fas fa-times"></i>
        </button>
    </div>
@endif
